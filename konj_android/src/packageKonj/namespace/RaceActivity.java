package packageKonj.namespace;

import android.app.Activity;
import android.app.AlertDialog;
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

public class RaceActivity extends Activity {
	int idRace;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.race);

        idRace = ((MyApp)getApplication()).getIdRace();
        
        if (idRace != 0) 
        {
     	    SQLiteDatabase myDB= null;
            myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
            Cursor c = myDB.rawQuery("SELECT * FROM race where id = " + idRace, null);
            
            int iid = c.getColumnIndex("id");
            int iname = c.getColumnIndex("rac_nam");
            int ichrono = c.getColumnIndex("rac_chrono");
            c.moveToFirst();
            int id = c.getInt(iid);
            ((TextView) findViewById(R.id.iDEditView)).setText(Integer.toString(id));
            String Name = c.getString(iname);
            ((EditText) findViewById(R.id.nameEditText)).setText(Name);
            String chrono = c.getString(ichrono);
            ((EditText) findViewById(R.id.chronoEditText)).setText(chrono);
            
            c.close();
            myDB.close();

            Button resultsButton = (Button) findViewById(R.id.resultsButton);
            resultsButton.setOnClickListener(resultsButtonListener);
            Button timerButton = (Button) findViewById(R.id.timerButton);
            timerButton.setOnClickListener(timerButtonListener);
            Button registrationButton = (Button) findViewById(R.id.registrationButton);
            registrationButton.setOnClickListener(registrationButtonListener);
        }
        else
        {
        	//ako je utrka nova onda nemože imati rezultate niti timer!!!
        	((Button) findViewById(R.id.resultsButton)).setEnabled(false);
        	((Button) findViewById(R.id.timerButton)).setEnabled(false);
        	((Button) findViewById(R.id.registrationButton)).setEnabled(false);
        }
        
        Button spremiButton = (Button) findViewById(R.id.spremiButton);
        spremiButton.setOnClickListener(spremiButtonListener);
        
        new setActivity().execute(); 
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
    	   String name = ((EditText) RaceActivity.this.findViewById(R.id.nameEditText)).getText().toString();
    	   String chrono = ((EditText) RaceActivity.this.findViewById(R.id.chronoEditText)).getText().toString();
    	   
    	   SQLiteDatabase myDB= null;
           myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
           String sql;
           if (idRace == 0)
           {
	           Cursor c = myDB.rawQuery("SELECT ifnull(max(id)+1,0) FROM race" , null);
	           c.moveToFirst();
	           idRace = c.getInt(0);
	           c.close();
	           sql = "insert into race(id,rac_nam,rac_chrono,rac_transfer) values (" + idRace + ",'" + name + "','" + chrono + "','M')" ; 
	           ((MyApp)getApplication()).setIdRace(idRace);
           }
           else
           {
	           sql = "update race set rac_nam = '" + name + "',rac_nam = '" + chrono + "',rac_transfer='U' where id = " + idRace ; 
           }
           
           try {      
               myDB.execSQL(sql);
               Toast.makeText(RaceActivity.this, "Spremljeno!", Toast.LENGTH_LONG).show();
               //Intent a = new Intent(RaceActivity.this,RacesActivity.class);
               //a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
               //startActivity(a);
           }
           catch (Exception e) {
               Toast.makeText(RaceActivity.this, "ERROR " + e.toString() + "\n\n" + sql, Toast.LENGTH_LONG).show();  
           }
           finally
           {
               myDB.close();
           }
       } 
    }; 
    public OnClickListener resultsButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {    	   
    	   AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(RaceActivity.this);
	   	   alertDialog2.show();
           Intent i = new Intent(RaceActivity.this, ResultsActivity.class);
           startActivity(i);
       } 
    };    
    
    public OnClickListener timerButtonListener = new OnClickListener()
    {
        @Override
        public void onClick(View v) 
        {
            Intent i = new Intent(RaceActivity.this, TimerActivity.class);
            startActivity(i);
        } 
    };
     
    public OnClickListener registrationButtonListener = new OnClickListener()
    {
        @Override
        public void onClick(View v) 
        {
            Intent i = new Intent(RaceActivity.this, RaceRegistrationActivity.class);
            i.putExtra("idRace", idRace);
            startActivity(i);
        } 
    };
	
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent a = new Intent(this,RacesActivity.class);
            a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(a);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    };
}