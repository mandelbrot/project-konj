package packageKonj.namespace;

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
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

public class PreferencesActivity extends Activity {
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.preferences);

        new setActivity().execute(); 
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 
        	
        	getPreferences();
        	
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  

    private class getPreferencesHelper extends AsyncTask<String, Void, SparseArray<String>> 
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

     	    SQLiteDatabase myDB= null;
            myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
            Cursor c = myDB.rawQuery("SELECT * FROM preferences", null);
            
            int iurl = c.getColumnIndex("server_url");
            int iupload = c.getColumnIndex("auto_upload");
            c.moveToFirst();

            Log.i("LOGGER", "... " + c.getString(iurl).toString());  
            String url = c.getString(iurl);
            EditText urlEdit = ((EditText) findViewById(R.id.serverUrlEditText));
            urlEdit.setText(url);

            Log.i("LOGGER", "... " + c.getString(iupload).toString());
            //boolean b = c.getInt(iupload) == 1 ? true : false;
            ((CheckBox) findViewById(R.id.chkAutoUpload)).setChecked(c.getInt(iupload) == 1 ? true : false);
    		//chkProcess.setChecked(c.getInt(iupload) == 1 ? true : false);	
            
            c.close();
            myDB.close();
            
            Button spremiButton = (Button) findViewById(R.id.spremiButton);
            spremiButton.setOnClickListener(spremiButtonListener);
        }
    }

    public void getPreferences()
    {
    	getPreferencesHelper task = new getPreferencesHelper();
        task.execute();
    }
    
    public OnClickListener spremiButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   String serverUrl = ((EditText) PreferencesActivity.this.findViewById(R.id.serverUrlEditText)).getText().toString();
    	   
    	   SQLiteDatabase myDB= null;
           myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
           String sql;
           sql = "update preferences " +
               " set server_url = '" + serverUrl + "'," +
               " auto_upload=" + (((CheckBox) findViewById(R.id.chkAutoUpload)).isChecked() ? "1" : "0") + 
               ""; 
           
           try {      
               myDB.execSQL(sql);
               Toast.makeText(PreferencesActivity.this, "Spremljeno!", Toast.LENGTH_LONG).show();
               Intent a = new Intent(PreferencesActivity.this, AdminActivity.class);
               a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
               startActivity(a);
           }
           catch (Exception e) {
               Toast.makeText(PreferencesActivity.this, "ERROR " + e.toString() + "\n\n" + sql, Toast.LENGTH_LONG).show();  
           }
           finally
           {
               myDB.close();
           }
       } 
    }; 
    
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent a = new Intent(this, AdminActivity.class);
            a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(a);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    };
}