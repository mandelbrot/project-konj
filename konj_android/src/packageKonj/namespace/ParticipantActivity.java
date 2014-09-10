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
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class ParticipantActivity extends Activity {
	int idParticipant;			
	String Name;
	String SurName;
	String Email;
	String Mob;
	String Sex;
	String Shirt;
	String Year;
	String Club;
	String transfer;
	int idRace;
	String newStartNumber;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.participant);

        idRace = ((MyApp)getApplication()).getIdRace();
        
        new setActivity().execute();
        
 	    if(idRace == 0)
 	    {
            Toast.makeText(getApplicationContext(),
                    "Nije postavljena utrka. Idi na meni 'Utrke' i odaberi utrku!", Toast.LENGTH_SHORT).show();
 		    return;
 	    }
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 

        	getParticipant();
        	
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  

    private class getParticipantHelper extends AsyncTask<String, Void, SparseArray<String>> 
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
            idParticipant = 0;
			
            CheckBox chkNewStart = (CheckBox) findViewById(R.id.chkNewStart);
				
            Bundle extras = getIntent().getExtras();
            if (extras != null) idParticipant = extras.getInt("idParticipant", 0);
            
            if (idParticipant != 0) 
            {
         	    SQLiteDatabase myDB= null;
                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                String sql = "SELECT p.id,p.per_nam,p.per_sur,p.per_sex, p.per_yea, p.per_mob,p.per_email,p.per_shi,per_clu," +
                    	" rr.st_num FROM participant p" + 
    					" left join race_reg rr on p.id=rr.per_id" +
    					" left join race r on rr.rac_id=r.id" +
    					" where p.id = " + idParticipant + " and r.id = " + idRace;
                Log.i("LOGGER", sql, null);
                Cursor c = myDB.rawQuery(sql, null);
                
                int iid = c.getColumnIndex("id");
                int iname = c.getColumnIndex("per_nam");
                int isurname = c.getColumnIndex("per_sur");
                int isex = c.getColumnIndex("per_sex");
                int iyear = c.getColumnIndex("per_yea");
                int imob = c.getColumnIndex("per_mob");
                int iemail = c.getColumnIndex("per_email");
                int ishirt = c.getColumnIndex("per_shi");
                int iclub = c.getColumnIndex("per_clu");
                int ist_num = c.getColumnIndex("st_num");
				
                String StartNumber="", Race;
                if(c.moveToFirst())
                {
                	Log.i("LOGGER", "sql je našao slog!", null);
	                ((TextView) findViewById(R.id.iDEditView)).setText(Integer.toString(c.getInt(iid)));
					
	                String Name = c.getString(iname);
	                ((EditText) findViewById(R.id.nameEditText)).setText(Name);
					
	                String Surname = c.getString(isurname);
	                ((EditText) findViewById(R.id.surnameEditText)).setText(Surname);

	                String Sex = c.getString(isex);
	                ((EditText) findViewById(R.id.sexEditText)).setText(Sex);
	                
	                String Year = c.getString(iyear);
	                ((EditText) findViewById(R.id.yearEditText)).setText(Year);
	                
	                String Mob = c.getString(imob);
	                ((EditText) findViewById(R.id.mobEditText)).setText(Mob);
	                
	                String Email = c.getString(iemail);
	                ((EditText) findViewById(R.id.emailEditText)).setText(Email);

	                String Shirt = c.getString(ishirt);
	                ((EditText) findViewById(R.id.shirtEditText)).setText(Shirt);

	                String Club = c.getString(iclub);
	                ((EditText) findViewById(R.id.clubEditText)).setText(Club);
	                
	                StartNumber = c.getString(ist_num);
					((TextView) findViewById(R.id.StartNumberTextView)).setText(StartNumber);
					
					util u = new util();
	                Race = u.getDBValue(ParticipantActivity.this, "race", "rac_nam", idRace);
					((TextView) findViewById(R.id.currentRaceTextView)).setText(Race);
					((TextView) findViewById(R.id.currentRaceTextView)).setTag(idRace);
                }
                c.close();
                myDB.close();
				
                //ako nije napao trkaèa ili ako je startni broj još uvijek null
				if (StartNumber == "" || StartNumber == null || StartNumber.isEmpty())
				{
					chkNewStart.setEnabled(true);
					myDB= null;
					myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
					/*c = myDB.rawQuery("SELECT ifnull(max(st_num), 0) + 1 as st_num, r.rac_nam FROM race_reg rr" + 
						" left join race r on rr.rac_id=r.id" +
						" where r.id = " + idRace, null);
					
					irace_name = c.getColumnIndex("rac_nam");
					ist_num = c.getColumnIndex("st_num");
					
					c.moveToFirst();

					StartNumber = c.getString(ist_num);
					((TextView) findViewById(R.id.StartNumberTextView)).setText(StartNumber);
					
					Race = c.getString(irace_name);
					((TextView) findViewById(R.id.currentRaceTextView)).setText(Race);

					c.close();*/
					
					sql = "SELECT p.id,p.per_nam,p.per_sur,p.per_sex, p.per_yea, " +
							" p.per_mob,p.per_email,p.per_shi,p.per_clu FROM participant p" + 
							" where p.id = " + idParticipant;
	                Log.i("LOGGER", sql, null);
					c = myDB.rawQuery(sql, null);
		                
	                iid = c.getColumnIndex("id");
	                iname = c.getColumnIndex("per_nam");
	                isurname = c.getColumnIndex("per_sur");
	                isex = c.getColumnIndex("per_sex");
	                iyear = c.getColumnIndex("per_yea");
	                imob = c.getColumnIndex("per_mob");
	                iemail = c.getColumnIndex("per_email");
	                ishirt = c.getColumnIndex("per_shi");
	                iclub = c.getColumnIndex("per_clu");
	                
					c.moveToFirst();
					
	                ((TextView) findViewById(R.id.iDEditView)).setText(Integer.toString(c.getInt(iid)));
					
	                String Name = c.getString(iname);
	                ((EditText) findViewById(R.id.nameEditText)).setText(Name);
					
	                String Surname = c.getString(isurname);
	                ((EditText) findViewById(R.id.surnameEditText)).setText(Surname);

	                String Sex = c.getString(isex);
	                ((EditText) findViewById(R.id.sexEditText)).setText(Sex);
	                
	                String Year = c.getString(iyear);
	                ((EditText) findViewById(R.id.yearEditText)).setText(Year);
	                
	                String Mob = c.getString(imob);
	                ((EditText) findViewById(R.id.mobEditText)).setText(Mob);
	                
	                String Email = c.getString(iemail);
	                ((EditText) findViewById(R.id.emailEditText)).setText(Email);

	                String Shirt = c.getString(ishirt);
	                ((EditText) findViewById(R.id.shirtEditText)).setText(Shirt);

	                String Club = c.getString(iclub);
	                ((EditText) findViewById(R.id.clubEditText)).setText(Club);
	                
	                c.close();
	                
	                c = myDB.rawQuery("SELECT ifnull(max(st_num) + 1, 1) as st_num FROM race_reg rr" + 
						" left join race r on rr.rac_id=r.id" +
						" where r.id = " + idRace, null);
	                
	                ist_num = c.getColumnIndex("st_num");

	                c.moveToFirst();

	                StartNumber = c.getString(ist_num);
	                newStartNumber = c.getString(ist_num);
					((TextView) findViewById(R.id.StartNumberTextView)).setText(StartNumber);

					util u = new util();
	                Race = u.getDBValue(ParticipantActivity.this, "race", "rac_nam", idRace);
					((TextView) findViewById(R.id.currentRaceTextView)).setText(Race);
					((TextView) findViewById(R.id.currentRaceTextView)).setTag(idRace);
					
	                c.close();
	                myDB.close();
					
					chkNewStart.setEnabled(true);
					chkNewStart.setChecked(false);	
				}
				else
				{
					chkNewStart.setEnabled(false);
					chkNewStart.setChecked(true);
				}
            }
            else
            {
            	//novi idParticipant se dodijeljuje tek kod inserta!!!
				SQLiteDatabase myDB= null;
                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                Cursor c = myDB.rawQuery("SELECT ifnull(max(st_num) + 1, 1) as st_num, r.rac_nam FROM race_reg rr" + 
					" left join race r on rr.rac_id=r.id" +
					" where r.id = " + idRace, null);
                
                int irace_name = c.getColumnIndex("rac_nam");
                int ist_num = c.getColumnIndex("st_num");

                c.moveToFirst();

                String StartNumber = c.getString(ist_num);
                newStartNumber = c.getString(ist_num);
				((TextView) findViewById(R.id.StartNumberTextView)).setText(StartNumber);
				
                String Race = c.getString(irace_name);
				((TextView) findViewById(R.id.currentRaceTextView)).setText(Race);

                c.close();
                myDB.close();
				
				chkNewStart.setEnabled(true);
				chkNewStart.setChecked(true);
            }
            
            Button spremiButton = (Button) findViewById(R.id.spremiButton);
            spremiButton.setOnClickListener(spremiButtonListener);   
            
			addListenerOnChkNewStart();
			
        }
    }

    public void getParticipant()
    {
    	getParticipantHelper task = new getParticipantHelper();
        task.execute();
    }
    
    public void addListenerOnChkNewStart() {
 
    	CheckBox chkNewStart = (CheckBox) findViewById(R.id.chkNewStart);
	 
		chkNewStart.setOnClickListener(new OnClickListener() {
		  @Override
		  public void onClick(View v) {
			TextView tvStartNumber = (TextView) findViewById(R.id.StartNumberTextView);
			if (((CheckBox) v).isChecked()) 
			{
				tvStartNumber.setText(newStartNumber);
			}
			else
			{
				tvStartNumber.setText("St. broj");
			}
		  }
		});
	}
	
    public OnClickListener spremiButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {		
    	   Name = ((EditText) ParticipantActivity.this.findViewById(R.id.nameEditText)).getText().toString();
    	   SurName = ((EditText) ParticipantActivity.this.findViewById(R.id.surnameEditText)).getText().toString();
    	   Year = ((EditText) ParticipantActivity.this.findViewById(R.id.yearEditText)).getText().toString();
    	   Mob = ((EditText) ParticipantActivity.this.findViewById(R.id.mobEditText)).getText().toString();
    	   Email = ((EditText) ParticipantActivity.this.findViewById(R.id.emailEditText)).getText().toString();
    	   Shirt = ((EditText) ParticipantActivity.this.findViewById(R.id.shirtEditText)).getText().toString();
    	   Sex = ((EditText) ParticipantActivity.this.findViewById(R.id.sexEditText)).getText().toString();
    	   Club = ((EditText) ParticipantActivity.this.findViewById(R.id.clubEditText)).getText().toString();
           
    	   SQLiteDatabase myDB= null;
           myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
           String sql, sql2;
           TextView tvStartNumber = (TextView) findViewById(R.id.StartNumberTextView);
		   String StartNumber = tvStartNumber.getText().toString();
           CheckBox chkNewStart = (CheckBox) findViewById(R.id.chkNewStart);
           
           if (idParticipant != 0)
           {
        	   transfer = "U";
	           sql = "update participant set per_nam = '" + Name + "', " + 
	        	   "per_sur = '" + SurName + "', " + 
	        	   "per_yea = '" + Year + "', " + 
	        	   "per_sex = '" + Sex + "', " + 
	        	   "per_mob = '" + Mob + "', " + 
	        	   "per_shi = '" + Shirt.toUpperCase() + "', " + 
	        	   "per_email = '" + Email + "', " + 
	        	   "per_clu = '" + Club + "', " + 
	        	   "per_transfer = '" + transfer + "' " + 
	               "where id = " + idParticipant + ";";	
	           
	           String s = "SELECT count(*) as c from race_reg where rac_id = " + idRace + " and per_id = " + idParticipant + " " +
						" and st_num = " + (newStartNumber == null ? StartNumber : newStartNumber);
			   Cursor c = myDB.rawQuery(s, null);
	           Log.i("SQL UPIT", s, null);
				
			   int ic = c.getColumnIndex("c");
			   int count = 0;
			   if (c.moveToFirst()) {
					do 
					{
						count = c.getInt(ic);
					}
					while(c.moveToNext());
			   }
				
			   c.close();
	           Log.i("U BAZI VEÆ POSTOJI OVAJ ST. BROJ? ", String.valueOf(count), null);
	           
			   sql2 = chkNewStart.isChecked() && count < 1 ? "insert into race_reg(rac_id,per_id,st_num,st_transfer) values (" + idRace + ", " + idParticipant + "," + newStartNumber + ",'M');" : ""; 
           }
           else
           {  
        	   transfer = "M";
	           Cursor c = myDB.rawQuery("SELECT ifnull(max(id)+1,0) FROM participant" , null);
	           c.moveToFirst();
	           idParticipant = c.getInt(0);
	           c.close();			

	           sql = "insert into participant(id,per_nam,per_sur,per_yea,per_sex,per_mob,per_shi,per_email,per_clu,per_transfer) " +
		               "values (" + idParticipant + ",'" + Name + "','" + SurName + "','" + Year + "','" + Sex + "','" + Mob + "'," +
		        	   "'" + Shirt.toUpperCase() + "','" + Email + "','" + Club + "','" + transfer + "')";
			   sql2 = chkNewStart.isEnabled() ? 
				   "insert into race_reg(rac_id,per_id,st_num,st_transfer) values (" + idRace + ", " + idParticipant + "," + newStartNumber + ",'M');" : 
				   "update race_reg set st_num = " + StartNumber + ", st_transfer='U' where rac_id = " + idRace + " and per_id = " + idParticipant + "\n"; 
           }
           
           try {      
                Log.i("LOGGER", sql, null);
                Log.i("LOGGER", sql2, null);
               myDB.execSQL(sql);
               if (sql2 != "" ) myDB.execSQL(sql2);
               
               util u = new util();
               if(u.autoUpload(ParticipantActivity.this) && u.isConnected(ParticipantActivity.this))
               {
       	        UploadTask task = new UploadTask();
       	        task.execute();
               }
               
               Toast.makeText(ParticipantActivity.this, sql  + "\n" + sql2 + "\n" + "Spremljeno!", Toast.LENGTH_LONG).show();
               Intent a = new Intent(ParticipantActivity.this,ParticipantsActivity.class);
               a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
               startActivity(a);
           }
           catch (Exception e) {
               Toast.makeText(ParticipantActivity.this, "ERROR " + e.toString() + "\n\n" + sql, Toast.LENGTH_LONG).show();  
           }
           finally
           {
               myDB.close();
           }
       } 
    }; 
    
    private class UploadTask extends AsyncTask<String, String, String>
    {
         
        @Override
        protected void onPreExecute() {
             
        }
             
        @Override
        protected String doInBackground(String... urls) {

        	String poruka = "";
        	
        	util u = new util();
            if(u.isConnected(ParticipantActivity.this))
            {
            	poruka = u.upload(ParticipantActivity.this, "participants", getJsonParticipant()); 
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
    
    private String getJsonParticipant()
    { 
		String json = "";
		
		JSONObject participant = new JSONObject();
		JSONObject participants = new JSONObject();
		
		try
		{
			participants.accumulate("type", "participants");

			participant.accumulate("id", idParticipant);
			participant.accumulate("per_nam", Name);
			participant.accumulate("per_sur", SurName);
			participant.accumulate("per_email", Email);
			participant.accumulate("per_mob", Mob);
			participant.accumulate("per_sex", Sex);
			participant.accumulate("per_shi", Shirt);
			participant.accumulate("per_yea", Year);
			participant.accumulate("per_clu", Club);
			participant.accumulate("per_transfer", transfer);
			
			participants.accumulate("participants", participant);
			//treba praznina jer inaèe ne prihvaæa json bez []
			participants.accumulate("participants", "");

			json = participants.toString();
			Log.i("LOGGER", json, null);
	    }
	    catch(Exception e)
        {
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
            e.printStackTrace();
        }

		return json;
    }
    
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent a = new Intent(this,ParticipantsActivity.class);
            a.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(a);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    };
}