package packageKonj.namespace;

import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;

public class util {
    public boolean isConnected(Context a){//ili umjesto Context Activity?
        ConnectivityManager connMgr = (ConnectivityManager) a.getSystemService(Context.CONNECTIVITY_SERVICE);
            NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
            if (networkInfo != null && networkInfo.isConnected())
                return true;
            else
                return false;    
    }
    
    public String getUploadUrl(Context a)
    {
    	SQLiteDatabase myDB= null;
		myDB = a.openOrCreateDatabase("konj", 1, null);
		Cursor c = myDB.rawQuery("SELECT server_url FROM preferences" , null);
		
		int iurl = c.getColumnIndex("server_url");
	    String url = "";
	    
		if (c.moveToFirst()) {
			do 
			{
				url = c.getString(iurl);
			}
			while(c.moveToNext());
		}
		
		c.close();
		myDB.close();
		
		return url;
    }

    //da se automatski uploada kod sejvanja participanta, kluba, rezultata,...
    public Boolean autoUpload(Context a)
    {
    	SQLiteDatabase myDB= null;
		myDB = a.openOrCreateDatabase("konj", 1, null);
		Cursor c = myDB.rawQuery("SELECT auto_upload FROM preferences" , null);
		
		int iupload = c.getColumnIndex("auto_upload");
	    Boolean b = false;
	    
		if (c.moveToFirst()) {
			do 
			{
				b = c.getInt(iupload) == 1 ? true : false;
			}
			while(c.moveToNext());
		}
		
		c.close();
		myDB.close();
		
		return b;
    }
    
    public String[] uploadHelper(Context c, String json)
    {
    	String poruka = "";
    	String webResponse = "start";
    	String uspjeh = "0";

        String[] a = new String[] {"0", ""};
        
        if(isConnected(c))
        {      
			HttpClient httpclient = new DefaultHttpClient();

			HttpPost httppost = new HttpPost(getUploadUrl(c));
			Log.i("LOGGER", getUploadUrl(c), null);
			httppost.setHeader("Accept", "application/json");
			httppost.setHeader("Content-type", "application/json");

    		try
    		{
				StringEntity se = new StringEntity(json);
	
				Log.i("LOGGER", "upload!", null);
				//127.0.0.1:8888/konj/WebServiceSOAP/server1.php
				//{"type":"clubs","clubs":{"id":7,"clu_transfer":"M","clu_nam":"ddd"}}
				httppost.setEntity(se);

		        a = new String[] {"0", "Server nije dostupan!"};
		        
		        HttpParams httpParameters = httppost.getParams();
		        int timeoutConnection = 500;
		        HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
		        int timeoutSocket = 500;
		        HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
		        
		        a = new String[] {"0", "Server je dostupan ali je došlo do greške!"};
		        
				HttpResponse response = httpclient.execute(httppost);  
				final int statusCode = response.getStatusLine().getStatusCode();

		        if (statusCode != HttpStatus.SC_OK)
		        {
		            Log.w(getClass().getSimpleName(), "Error " + statusCode + " for URL " + httppost);
		    		return new String[] {"0", "Upload nije uspio!"};
		        }
		        
				webResponse = EntityUtils.toString(response.getEntity());
	    		
				if(webResponse == null)
				{
	                poruka = "Upload nije uspio!";
	                uspjeh = "0";
				}
				else if (webResponse.indexOf("success") != -1 || webResponse.indexOf("Empty") != -1)
				{
	                poruka = "Podaci uspješno uploadani!";
	                uspjeh = "1";
				}
				else
				{
					poruka = "Podaci poslani ali upload nije uspio!";
	                uspjeh = "0";
				}
				
				Log.i("LOGGER", poruka + "\n" + webResponse, null);
                a = new String[] {uspjeh, poruka + "\n" + webResponse};
    	    }
    	    catch(Exception e)
            {
                a = new String[] {"0", "Upload nije uspio\n" + e.toString()};
                Log.e("Error", "Error", e);
                e.printStackTrace();
            }
        }
        else
        {
            a = new String[] {"0", "Internet nije dostupan!"};
			Log.i("LOGGER", "Internet nije dostupan!", null);
        }	
        
        return a;
    }
    
	public String upload(Context c, String type, String json)
	{
		String poruka = "Ništa nije bilo uploadano";       

		try 
		{  
			String[] a;
			if(type == "results_backup" || type == "results" || type == "registrations" || type == "participants"  || type == "participants_backup" || type == "clubs" || type == "process")
				a = uploadHelper(c, json);
			else
				a = new String[] {"0", "Ništa nije bilo uploadano"};
			
			poruka = a[1];
			
			if(a[0] == "1")
	            Log.i("LOGGER", a[1], null);
			else
	            Log.e("Error", a[1], null);
		}
		catch (Exception e) {
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}

		return poruka;
	}    
	
    public boolean getRaceChrono(Context co, int idRace)
    {
    	boolean chronoRace = false;
        DatabaseConnector dc = new DatabaseConnector(co);
        Cursor c = dc.getRaceChrono(idRace);
        if(c.moveToFirst())
        {
        	String chrono = (c.isNull(c.getColumnIndex("rac_chrono"))) ? "" : 
        		c.getString(c.getColumnIndex("rac_chrono")).toUpperCase();
        	chronoRace = (chrono.equals("D") || chrono.equals("Y")) ? true : false; 
        }
        dc.close();
        
        return chronoRace;
    }  
    
    public String getDBValue(Context co, String table, String columnName, int id)
    {
    	String val = "";
        DatabaseConnector dc = new DatabaseConnector(co);
        Cursor c = dc.getValue(table, columnName, id);
        if(c.moveToFirst())
        {
        	val = (c.isNull(c.getColumnIndex(columnName))) ? "" : 
        		c.getString(c.getColumnIndex(columnName));
        }
        dc.close();
        
        return val;
    }
    
    public long resultString2Long(String result)
    {
 	   String[] parts = result.split(":");
 	   long noviResLong;
 	   if(parts.length == 2)
 		   noviResLong = 1000 * (Integer.parseInt(parts[0])*60 + Integer.parseInt(parts[1]));
 	   else if(parts.length == 3)
 		   noviResLong = 1000 * (Integer.parseInt(parts[0])*60*60 + Integer.parseInt(parts[1])*60 + Integer.parseInt(parts[2]));
 	   else if(parts.length == 4)
 		   noviResLong = 1000 * (Integer.parseInt(parts[0])*60*60*24 + Integer.parseInt(parts[1])*60*60 + Integer.parseInt(parts[2])*60 + Integer.parseInt(parts[3]));
 	   else
 		   noviResLong = 1000 * (Integer.parseInt(parts[0])*60*60 + Integer.parseInt(parts[1])*60 + Integer.parseInt(parts[2]));
 	   return noviResLong;  
    }   
    
    public String resultLong2String(long diff)
    {
	    int days = (int) (diff >= 1000*60*60*24 ? diff / 1000*60*60*24 : 0); 
        int hours = (int) (diff >= 1000*60*60 ? (diff - 1000*60*60*24*days) / 1000*60*60 : 0); 
        int min = (int) (diff >= 1000*60 ? (diff - 1000*60*60*hours) / (1000*60) : 0);
        int sec = (int) (diff - 1000*60*60*hours - 1000*60*min) / 1000;
	           
    	String vrijemeRucno = days > 0 ? ("00" + String.valueOf(days)).substring(("00" + String.valueOf(days)).length() - 2, 
    			("00" + String.valueOf(days)).length()) + ":" : "";
    	vrijemeRucno += 
		            ("00" + String.valueOf(hours)).substring(("00" + String.valueOf(hours)).length() - 2, 
		            		("00" + String.valueOf(hours)).length()) + ":" +
		            ("00" + String.valueOf(min)).substring(("00" + String.valueOf(min)).length() - 2, 
		            		("00" + String.valueOf(min)).length()) + ":" +
		            ("00" + String.valueOf(sec)).substring(("00" + String.valueOf(sec)).length() - 2, 
		            		("00" + String.valueOf(sec)).length());
    	return vrijemeRucno;
    }
    
}
