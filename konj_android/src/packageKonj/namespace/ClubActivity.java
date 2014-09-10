package packageKonj.namespace;

import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.util.SparseArray;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class ClubActivity extends Activity {
	int idClub;
	String name;
	String transfer;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.club);

        new setActivity().execute(); 
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 

        	getClub();
        	
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  

    private class getClubHelper extends AsyncTask<String, Void, SparseArray<String>> 
    {
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected SparseArray<String> doInBackground(String... urls) {
        	return null;
        }
      
        @Override
        protected void onPostExecute(SparseArray<String> result) 
        {
        	idClub = 0;
           
        	Bundle extras = getIntent().getExtras();
        	if (extras != null) idClub = extras.getInt("idClub", 0);
        	
          	if (idClub != 0) 
           	{
        	    SQLiteDatabase myDB= null;
                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                Cursor c = myDB.rawQuery("SELECT * FROM club where id = " + idClub, null);
               
                int iid = c.getColumnIndex("id");
                int iname = c.getColumnIndex("clu_nam");
                c.moveToFirst();
                int id = c.getInt(iid);
                //TextView tv = (TextView) findViewById(R.id.iDEditView);
                //tv.setText(Integer.toString(id));
                ((TextView) findViewById(R.id.iDEditView)).setText(Integer.toString(id));
                name = c.getString(iname);
                ((EditText) findViewById(R.id.nameEditText)).setText(name);
               
                c.close();
                myDB.close();
           	}
          	else
          	{
           	//uzmi novi id iz baze idClub
           	//idClub = "1234";
           	//uzima tek kod inserta!!!
          	}
           
          	Button spremiButton = (Button) findViewById(R.id.spremiButton);
          	spremiButton.setOnClickListener(spremiButtonListener); 
        }
    }

    public void getClub()
    {
    	getClubHelper task = new getClubHelper();
        task.execute();
    }
    
    public OnClickListener spremiButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   //EditText et = (EditText) ClubActivity.this.findViewById(R.id.nameEditText);
    	   //String name = et.getText().toString();

    	   name = ((EditText) ClubActivity.this.findViewById(R.id.nameEditText)).getText().toString();
    	   
    	   SQLiteDatabase myDB= null;
           myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
           String sql;
           if (idClub == 0)
           {
	           Cursor c = myDB.rawQuery("SELECT ifnull(max(id) + 1, 0) FROM club" , null);
	           c.moveToFirst();
	           idClub = c.getInt(0);
	           c.close();
	           //sql = "insert into club(id,clu_nam,clu_transfer) values (" + idClub + ",'" + name + "','M')" ; 
	           sql = "I";
           }
           else
           {
	           //sql = "update club set clu_nam = '" + name + "',clu_transfer='U' where id = " + idClub ; 
	           sql = "U";
           }
           
           try {      
               //myDB.execSQL(sql);
	           if (sql == "I") 
	           {
	        	   transfer = "M";
	        	   saveClub();
	           }
	           else 
	           {
	        	   transfer = "U";
	        	   updateClub();
	           }
               Toast.makeText(ClubActivity.this, "Spremljeno!", Toast.LENGTH_LONG).show();  
               //finish();
               //Intent i = new Intent(ClubActivity.this, ClubsActivity.class);
               //startActivity(i);
               Intent a = new Intent(ClubActivity.this,ClubsActivity.class);
               a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
               startActivity(a);
           }
           catch (Exception e) {
               Toast.makeText(ClubActivity.this, "ERROR " + e.toString() + "\n\n" + sql, Toast.LENGTH_LONG).show();  
           }
           finally
           {
               myDB.close();
           }
       } 
    }; 
    
    private void saveClub() 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.insertClub(idClub, name, transfer);
        
        util u = new util();
        if(u.autoUpload(this) && u.isConnected(this))
        {
	        UploadTask task = new UploadTask();
	        task.execute();
        }
    } 
    
    private class UploadTask extends AsyncTask<String, String, String>
    {
         
        @Override
        protected void onPreExecute() {
             
        }
             
        @Override
        protected String doInBackground(String... urls) {

        	String poruka = "";
        	
        	util u = new util();
            if(u.isConnected(ClubActivity.this))
            {
            	poruka = u.upload(ClubActivity.this, "clubs", getJsonClub()); 
        	}
            else
            {
            	poruka = "You are not connected to Internet...";
            }  
            
        	return poruka;
        }
      
        @Override
        protected void onPostExecute(String result) 
        {
            Toast.makeText(getApplicationContext(), result, Toast.LENGTH_LONG).show();
        }
    }
    
    private String getJsonClub()
    { 
		String json = "";
		
		JSONObject club = new JSONObject();
		JSONObject clubs = new JSONObject();
		
		try
		{
			clubs.accumulate("type", "clubs");

			club.accumulate("id", idClub);
			club.accumulate("clu_nam", name);
			club.accumulate("clu_transfer", transfer);
			
			clubs.accumulate("clubs", club);
			//treba praznina jer inaèe ne prihvaæa json bez []
			clubs.accumulate("clubs", "");

			json = clubs.toString();
			Log.i("LOGGER", json, null);
 
	    }
	    catch(Exception e)
        {
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
            e.printStackTrace();
        }

		return json;
    }
    
    private void updateClub() 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.updateClub(idClub, name, "U");    	
        
        util u = new util();
        if(u.autoUpload(this) && u.isConnected(this))
        {
	        UploadTask task = new UploadTask();
	        task.execute();
        }
    } 

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent a = new Intent(this,ClubsActivity.class);
            a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(a);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    };
}
