package packageKonj.namespace;

import java.io.IOException;
import java.io.InputStream;

import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class KonjActivity extends Activity {
	private TextView tvWS;
	private TextView tv;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
/*        Bundle extras = getIntent().getExtras();
        if (extras != null) 
        {
        	idRace = extras.getString("idRace");
        }*/
       /* Intent i = new Intent(TimerActivity.this, ResultActivity.class);
        i.putExtra("idResult",idResult);
        startActivity(i);*/
        
        new setActivity().execute();   
    }
    
    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 

        	tvWS = (TextView) findViewById(R.id.wsTextView);
            tv = (TextView) findViewById(R.id.konjTextView);
            
            //((MyApp)getApplication()).setIdRace(6);
            
            createDB();
            
            /*AlertDialog.Builder a = new AlertDialog.Builder(ParticipantsActivity.this);
     	    a.setTitle("Potvrdi brisanje...");
     	    a.setMessage("Brisanje natjecatelja '" + nameParticipant + "'?");
     	    a.show();*/
     	    
            util u = new util();
            if(u.isConnected(KonjActivity.this))
            {
    	        //simpleTestWS(tvWS);
    	        //simpleTestPOST(tv);
            }
            else
            {
                Toast.makeText(getApplicationContext(),"You are not connected to Internet...", Toast.LENGTH_LONG).show();
            }
            
            Button timerButton = (Button) findViewById(R.id.timerButton);
            timerButton.setOnClickListener(timerButtonListener);

            Button raceButton = (Button) findViewById(R.id.raceButton);
            raceButton.setOnClickListener(raceButtonListener);

            Button participantButton = (Button) findViewById(R.id.participantButton);
            participantButton.setOnClickListener(participantButtonListener);

            Button clubButton = (Button) findViewById(R.id.clubButton);
            clubButton.setOnClickListener(clubButtonListener);

            Button adminButton = (Button) findViewById(R.id.adminButton);
            adminButton.setOnClickListener(adminButtonListener);

            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
			util u = new util();
            /*String Race = u.getDBValue(KonjActivity.this, "race", "rac_nam", ((MyApp)getApplication()).getIdRace());
            Toast.makeText(getApplicationContext(), ((MyApp)getApplication()).getIdRace() == 0 ? "Utrka nije postavljena!" : 
            	"Trenutna utrka je '" + Race + "'", Toast.LENGTH_LONG).show(); */
        } 
    }  
    
    public OnClickListener timerButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(KonjActivity.this, TimerActivity.class);
           startActivity(i);
       } 
    }; 
    
    public OnClickListener raceButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(KonjActivity.this, RacesActivity.class);
           startActivity(i);
       } 
    };
    
    public OnClickListener participantButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(KonjActivity.this, ParticipantsActivity.class);
           startActivity(i);
       } 
    }; 
    
    public OnClickListener clubButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(KonjActivity.this, ClubsActivity.class);
           startActivity(i);
       } 
    };
    
    public OnClickListener adminButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(KonjActivity.this, AdminActivity.class);
           startActivity(i);
       } 
    }; 
    
    public void createDB(){

        SQLiteDatabase myDB= null;
       
        try 
        {
			myDB = this.openOrCreateDatabase("konj", MODE_PRIVATE, null);
			//myDB = (SQLiteDatabase) getBaseContext().getAssets().open("myfile.db");
			//myDB = SQLiteDatabase.openDatabase(this.getPackageManager().getPackageInfo(getPackageName(), 0).applicationInfo.dataDir + "/konj.db", null, SQLiteDatabase.OPEN_READWRITE);
			try 
			{
				myDB.execSQL("CREATE TABLE club ( " +
				"    id           INT( 3 )       PRIMARY KEY" +
				"                                NOT NULL," +
				"    clu_nam      VARCHAR( 40 )  NOT NULL," +
				"    clu_transfer VARCHAR( 1 ) " +
				");");
			}
			catch(Exception e) 
		    {
		    	Log.e("Error", "Greška kod kreiranja tablice club", e);
		    }
			finally{}
 
	        try 
	        {
	        	myDB.execSQL("CREATE TABLE preferences ( " +
				"    server_url  VARCHAR( 100 )," +
				"    auto_upload INT " +
				");");
				myDB.execSQL("INSERT INTO [preferences] ([server_url], [auto_upload]) VALUES ('http://www.konj.315-sjeverozapad.hr/WebServiceSOAP/server.php', 1);");
	        }
	        catch(Exception e) 
			{
			   	Log.e("Error", "Greška kod kreiranja tablice preferences", e);
			}
	        finally{}
         
	        try 
	        {
	        	myDB.execSQL("CREATE TABLE participant ( " +
				"    id           INT            PRIMARY KEY" +
				"                                NOT NULL," +
				"    per_nam      VARCHAR( 30 )  NOT NULL," +
				"    per_sur      VARCHAR( 30 )  NOT NULL," +
				"    per_shi      VARCHAR( 1 )," +
				"    per_yea      VARCHAR( 4 )," +
				"    per_sex      VARCHAR( 1 )," +
				"    per_email    VARCHAR( 30 )," +
				"    per_mob      VARCHAR( 20 )," +
				"    per_transfer VARCHAR( 1 )," +
				"    per_clu      VARCHAR( 40 ) " +
				");");
	        }
	        catch(Exception e) 
		    {
		    	Log.e("Error", "Greška kod kreiranja tablice participant", e);
		    }
	        finally{}
         
	        try 
	        {
	        	//myDB.execSQL("drop TABLE race_result;");
	        	
	        	myDB.execSQL("CREATE TABLE race_result (" + 
				"    id            INTEGER        PRIMARY KEY ASC AUTOINCREMENT," +
				"    rac_id        INT            NOT NULL," +
				"    st_num        INT," +
				"    res_dt        DATETIME," +
				"    res_time      VARCHAR( 10 )," +
				"    res_typ       VARCHAR( 3 )," +
				"    res_dt_org    DATETIME," +
				"    res_time_org  VARCHAR( 10 )," +
				"    res_sec       INTEGER," +
				"    res_sec_org   INTEGER," +
				"    res_start     DATETIME," +
				"    res_start_org DATETIME " +
				");");
		    }
		    catch(Exception e) 
		    {
		    	Log.e("Error", "Greška kod kreiranja tablice race_result", e);
		    }
		    finally{}
        
	        try 
	        {
	        	myDB.execSQL("CREATE TABLE race (" + 
				"    id            INT            PRIMARY KEY" +
				"                                 NOT NULL," +
				"    rac_nam       VARCHAR( 80 )  NOT NULL," +
				"    rac_transfer  VARCHAR( 1 )," +
				"    rac_start     DATETIME," +
				"    rac_start_sec INTEGER," +
				"    rac_chrono    VARCHAR( 1 )" + 
				");");
	        }
	        catch(Exception e) 
	        {
		    	Log.e("Error", "Greška kod kreiranja tablice race", e);
	        }
	        finally{}
    
	        try 
	        {
	            myDB.execSQL("CREATE TABLE race_reg (" + 
				"    rac_id      INT           NOT NULL" +
				"                              REFERENCES race ( id )," +
				"    per_id      INT           NOT NULL" +
				"                              REFERENCES participant ( id )," +
				"    st_num      INT           NOT NULL," +
				"    st_transfer VARCHAR( 1 ) " +
				");");
		    }
		    catch(Exception e) 
		    {
		    	Log.e("Error", "Greška kod kreiranja tablice race_reg", e);
		    }
		    finally{} 
        }
        catch(Exception e) 
        {
			Log.e("Error", "Error", e);
			Log.i("Error", "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", e);
        } 
        finally 
        {
        	if (myDB != null)
        	myDB.close();
        }
    }
    
    private class SoapAccessTask extends AsyncTask<String, Void, String> 
    {
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected String doInBackground(String... urls) {
        	String webResponse = "start";
        	try{
             final String NAMESPACE = "http://www.webserviceX.NET/";
             final String URL = "http://www.webservicex.net/CurrencyConvertor.asmx";
             final String SOAP_ACTION = "http://www.webserviceX.NET/ConversionRate";
             final String METHOD_NAME = "ConversionRate";

             InputStream inputStream = null;
             String result = null;
             
/*             HttpClient httpclient = new DefaultHttpClient();
             HttpGet httppost = new HttpGet("http://10.0.2.2:8888/konj/WebServiceSOAP/server1.php?p=clubs");
             httppost.setHeader("Content-type", "application/json");*/
             try {
                //HttpResponse response = httpclient.execute(httppost);       
                //HttpEntity entity = response.getEntity();
            	 
                //final String str =  EntityUtils.toString(response.getEntity());
                
/*                inputStream = entity.getContent();
                // json is UTF-8 by default
                BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream, "UTF-8"), 8);
                StringBuilder sb = new StringBuilder();

                String line = null;
                while ((line = reader.readLine()) != null)
                {
                    sb.append(line + "\n");
                }
                result = sb.toString();*/
                // Creating JSON Parser instance
                
            	webResponse="";
            	 
                JSONParser jParser = new JSONParser();

                JSONObject json = jParser.getJSONFromUrl("http://10.0.2.2:8888/konj/WebServiceSOAP/server1.php?p=clubs");

                try {
                	JSONArray contacts = null;
                    contacts = json.getJSONArray("clubs");

                    for(int i = 0; i < contacts.length(); i++){
                        JSONObject c = contacts.getJSONObject(i);

                        String id = c.getString("id");
                        String name = c.getString("name");
                        webResponse += id + name + "---";
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                
                //webResponse=result;
             }
             catch (Exception e) {
                 Log.e("Error", "Error", e);
                 e.printStackTrace();
             }
          }
          catch(Exception e)
          {
              //Toast.makeText(getApplicationContext(),"Cannot access the web service"+e.toString(), Toast.LENGTH_LONG).show();
              Log.e("Error", "Error", e);
              e.printStackTrace();
          }
          return webResponse;
       }
      
       @Override
       protected void onPostExecute(String result) {
               //if you started progress dialog dismiss it here
               tvWS.setText(result);
               Toast.makeText(getApplicationContext(),"Completed...", Toast.LENGTH_LONG).show();
            }
        }

    public void simpleTestWS(View view)
    {
    	SoapAccessTask task = new SoapAccessTask();
        task.execute();
    }
    
    private class PostTask extends AsyncTask<String, Void, String> 
    {
         
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected String doInBackground(String... urls) {
        	String webResponse = "start";       
        	try{
				HttpClient httpclient = new DefaultHttpClient();
				HttpPost httppost = new HttpPost("http://10.0.2.2:8888/konj/WebServiceSOAP/server1.php");
				httppost.setHeader("Accept", "application/json");
				httppost.setHeader("Content-type", "application/json");
				try 
				{  
		            String json = "";

		            JSONObject jsonObject = new JSONObject();
		            jsonObject.accumulate("clu_nam", "test_klub");
		            jsonObject.accumulate("clu_adr", "test_adresa");
		            jsonObject.accumulate("clu_tow", "test_grad");
		            
		            JSONObject club = new JSONObject();
		            club.accumulate("type", "club");
		            club.accumulate("club", jsonObject);
		 
		            json = club.toString();
		 
		            StringEntity se = new StringEntity(json);

		            httppost.setEntity(se);

				    HttpResponse response = httpclient.execute(httppost);   
		            webResponse =  EntityUtils.toString(response.getEntity());
		            //webResponse = json;
		            if(webResponse == null)
		            	webResponse = "Did not work!";
				}
				catch (IOException e) {
					Log.e("Error", "Error", e);
					e.printStackTrace();
				}
          }
          catch(Exception e)
          {
              //Toast.makeText(getApplicationContext(),"Cannot access the web service"+e.toString(), Toast.LENGTH_LONG).show();
              Log.e("Error", "Error", e);
              e.printStackTrace();
          }
          return webResponse;
       }
      
       @Override
       protected void onPostExecute(String result) 
       {
           tv.setText(result);
           Toast.makeText(getApplicationContext(),"Completed...", Toast.LENGTH_LONG).show();
       }
    }
    
    public void simpleTestPOST(View view)
    {
    	PostTask task = new PostTask();
        task.execute();
    }
}