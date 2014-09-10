package packageKonj.namespace;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class ResultActivity extends Activity {
	int idRace;
	int idResult;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.result);

    	idRace = ((MyApp)getApplication()).getIdRace();

    	util u = new util();
        if(!u.getRaceChrono(this, idRace))
        {
    		EditText ev = (EditText) findViewById(R.id.resultStartEditText);
    		ev.setVisibility(View.GONE);
    		TextView tv = (TextView) findViewById(R.id.resultStartTextView);
    		tv.setVisibility(View.GONE);
        }
        
        //new setActivity().execute(); 
        idResult = 0;
        
        Bundle extras = getIntent().getExtras();
        if (extras != null) idResult = extras.getInt("idResult", 0);
        
        if (idResult != 0) 
        {
     	    SQLiteDatabase myDB= null;
            myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
            Cursor c = myDB.rawQuery("SELECT * FROM race_result where id = " + idResult, null);
            
            int iid = c.getColumnIndex("id");
            int iname = c.getColumnIndex("st_num");
            int iresult = c.getColumnIndex("res_time");
            int iresulttime = c.getColumnIndex("res_dt");
            int iresultstart = c.getColumnIndex("res_start");
            c.moveToFirst();
            int id = c.getInt(iid);
            ((TextView) findViewById(R.id.iDEditView)).setText(Integer.toString(id));
            String Name = c.getString(iname);
            ((EditText) findViewById(R.id.nameEditText)).setText(Name);
            String result = c.getString(iresult);
            ((EditText) findViewById(R.id.resultEditText)).setText(result);
            String resultTime = c.getString(iresulttime);
			   Log.i("Error", resultTime, null);
            ((EditText) findViewById(R.id.resultTimeEditText)).setText(resultTime); 
            String resultStart = c.getString(iresultstart);
			   Log.i("Error", resultStart, null);
            ((EditText) findViewById(R.id.resultStartEditText)).setText(resultStart); 
            
            c.close();
            myDB.close();
        }
        
        Button spremiButton = (Button) findViewById(R.id.spremiButton);
        spremiButton.setOnClickListener(spremiButtonListener);
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 

            
            
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
    
    public OnClickListener spremiButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   String stNum = ((EditText) ResultActivity.this.findViewById(R.id.nameEditText)).getText().toString();
    	   String result = ((EditText) ResultActivity.this.findViewById(R.id.resultEditText)).getText().toString();
    	   String resultStart = ((EditText) ResultActivity.this.findViewById(R.id.resultStartEditText)).getText().toString();
    	   String resultTime = ((EditText) ResultActivity.this.findViewById(R.id.resultTimeEditText)).getText().toString();
    	   
    	   SQLiteDatabase myDB= null;
           myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
           String sql;
           
           if (idResult == 0)
           {
	           Cursor c = myDB.rawQuery("SELECT ifnull(max(id) + 1, 1) FROM race_result" , null);
	           c.moveToFirst();
	           idResult = c.getInt(0);
	           c.close();
			   DateFormat formatter; 
			   formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	           Date d1;
	           try
	           {
	        	   d1= formatter.parse(resultTime);
	 	           Calendar StartCalendar = Calendar.getInstance();
		           StartCalendar.setTime(d1);
	           }
	           catch (Exception e)
	           {
	               //Toast.makeText(ResultActivity.this, "ERROR " + e.toString(), Toast.LENGTH_LONG).show();  
	           }
	           finally
	           {
	        	   util u = new util();
		           sql = "insert into race_result(id, rac_id, st_num, res_time,res_time_org,res_dt,res_dt_org,res_sec,res_sec_org,res_start,res_start_org) " +
			           		"values (" + idResult + "," + idRace + "," + stNum + ",'" + result + "','" + result + "','" + resultTime + "','" + resultTime + "'," +
			           		u.resultString2Long(result) + "," + u.resultString2Long(result) + ",'" + resultStart + "','" + resultStart + "')" ; 
	           }
           }
           else
           {
        	   DateFormat formatter; 
			   formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	           Date d1;
	           try
	           {
	        	   d1= formatter.parse(resultTime);
	 	           Calendar StartCalendar = Calendar.getInstance();
		           StartCalendar.setTime(d1);
	           }
	           catch (Exception e)
	           {
	               //Toast.makeText(ResultActivity.this, "ERROR " + e.toString(), Toast.LENGTH_LONG).show();  
	           }
	           finally
	           {
	        	   util u = new util();
	        	   sql = "update race_result set st_num = " + stNum + ", "+
	  	        		 " res_time = '" + result + "', res_dt = '" + resultTime + "', res_sec= " + u.resultString2Long(result) + ", " +
	  	        		 " res_start = '" + resultStart + "'" + 
	  	        		 " where id = " + idResult ; 
	           } 
           }
           
           try {      
   			   Log.i("Error", sql, null);
               myDB.execSQL(sql);
               Toast.makeText(ResultActivity.this, "Spremljeno!", Toast.LENGTH_LONG).show();
               Intent a = new Intent(ResultActivity.this,ResultsActivity.class);
               a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
               startActivity(a);
           }
           catch (Exception e) {
               Toast.makeText(ResultActivity.this, "ERROR " + e.toString() + "\n\n" + sql, Toast.LENGTH_LONG).show();  
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
            Intent a = new Intent(this,ResultsActivity.class);
            a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(a);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    };
}