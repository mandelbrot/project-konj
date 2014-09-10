package packageKonj.namespace;

import org.json.JSONArray;
import org.json.JSONObject;
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
import android.widget.CheckBox;
import android.widget.TextView;
import android.widget.Toast;

public class AdminActivity extends Activity {
	int idRace;
	int upload;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.admin);

        new setActivity().execute(); 	

        idRace = ((MyApp)getApplication()).getIdRace();
        SQLiteDatabase myDB= null;
        myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
        Cursor c = myDB.rawQuery("SELECT rac_nam from race where id = " + idRace, null);
        
        int iname = c.getColumnIndex("rac_nam");
		
        String Race = c.moveToFirst() ? c.getString(iname) : "utrka";
		((TextView) findViewById(R.id.currentRaceTextView)).setText(Race);

        c.close();
        myDB.close();
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 
			
            CheckBox chkProcess = (CheckBox) findViewById(R.id.chkProcess);
            chkProcess.setChecked(false);

            Button uploadClubsButton = (Button) findViewById(R.id.uploadClubsButton);
            uploadClubsButton.setOnClickListener(uploadClubsButtonListener);   
            Button uploadParticipants = (Button) findViewById(R.id.uploadParticipantsButton);
            uploadParticipants.setOnClickListener(uploadParticipantsButtonListener);   
            Button uploadResults = (Button) findViewById(R.id.uploadResultsButton);
            uploadResults.setOnClickListener(uploadResultsButtonListener);   
            Button uploadAll = (Button) findViewById(R.id.uploadAllButton);
            uploadAll.setOnClickListener(uploadAllButtonListener);   

            Button download = (Button) findViewById(R.id.downloadButton);
            download.setOnClickListener(downloadButtonListener);   

            Button preferences = (Button) findViewById(R.id.preferencesButton);
            preferences.setOnClickListener(preferencesButtonListener);   
            
			addListenerOnChkNewStart();
			
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
	
    public void addListenerOnChkNewStart() {
 
    	CheckBox chkProcess = (CheckBox) findViewById(R.id.chkProcess);
	 
    	chkProcess.setOnClickListener(new OnClickListener() {
		  @Override
		  public void onClick(View v) {
			  
		  }
		});
	}
	
    public OnClickListener uploadClubsButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
		   util u = new util();
		   if(u.isConnected(AdminActivity.this))
		   {
			   upload = 0;
			   uploadWS();
		   }
		   else
		   {
		       Toast.makeText(getApplicationContext(), "You are not connected to Internet...", Toast.LENGTH_LONG).show();
		   }
       } 
    }; 
    
    public OnClickListener uploadParticipantsButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   util u = new util();
		   if(u.isConnected(AdminActivity.this))
		   {
			   upload = 1;
			   uploadWS();
		   }
		   else
		   {
		       Toast.makeText(getApplicationContext(), "You are not connected to Internet...", Toast.LENGTH_LONG).show();
		   }
       } 
    };
    
    public OnClickListener uploadResultsButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   util u = new util();
		   if(u.isConnected(AdminActivity.this))
		   {
			   upload = 2;
			   uploadWS();
		   }
		   else
		   {
		       Toast.makeText(getApplicationContext(), "You are not connected to Internet...", Toast.LENGTH_LONG).show();
		   }
       } 
    }; 
    
    public OnClickListener uploadAllButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   util u = new util();
		   if(u.isConnected(AdminActivity.this))
		   {
			   upload = 3;
			   uploadWS();
		   }
		   else
		   {
		       Toast.makeText(getApplicationContext(), "You are not connected to Internet...", Toast.LENGTH_LONG).show();
		   }
       } 
    };
    
    public OnClickListener downloadButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
	       downloadWS();
       } 
    }; 

    public OnClickListener preferencesButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(AdminActivity.this, PreferencesActivity.class);
           startActivity(i);
       } 
    };
    
    private class DownloadTask extends AsyncTask<String, Void, Void> 
    {
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected Void doInBackground(String... urls) {
        	
			downloadClubs();
			downloadParticipants();
			downloadRaces();
			downloadRegistrations();
			downloadResults();
			
			return null;
        }
      
        protected void onPostExecute() 
        {
             //if you started progress dialog dismiss it here
             //tvWS.setText(result);
	    	 //if (result != null) refreshButtons(result); 
             Toast.makeText(getApplicationContext(), "Podaci skinuti!", Toast.LENGTH_LONG).show();
        }
    }

    public void downloadWS()
    {
    	DownloadTask task = new DownloadTask();
        task.execute();
    }

	public void downloadClubs()
	{
		try
		{
            JSONParser jParser = new JSONParser();
            util u = new util();
            JSONObject json = jParser.getJSONFromUrl(u.getUploadUrl(AdminActivity.this) + "?p=clubs");

			try {
				JSONArray clubs = null;
				//Log.i("Error", String.valueOf(json.length()), null);
				clubs = json.getJSONArray("clubs");
			 
				SQLiteDatabase myDB= null;
				myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
				String sql = "";
				
				//prvo backup postojeæih klubova
				//myDB.execSQL("create table club_" + new SimpleDateFormat("yyyyMMdd_HHmmss").format(Calendar.getInstance().getTime()) + " as select * from club");
				//izbriši klubove
				myDB.execSQL("delete from club");
			
				for(int i = 0; i < clubs.length(); i++){
					JSONObject c = clubs.getJSONObject(i);
					String id = c.getString("id");
					String name = c.getString("clu_nam");
					String transfer = c.getString("clu_transfer");
					sql = "insert into club(id, clu_nam, clu_transfer) values (" + id + ",'" + name + "','" + transfer + "');";
					myDB.execSQL(sql);
				}
				
				myDB.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		catch (Exception e) 
		{
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}
	}

	public void downloadParticipants()
	{
        util u = new util();
		String poruka = u.upload(AdminActivity.this, "participants_backup", getJsonParticipants("participants_backup"));
		if (poruka.indexOf("uspješno") == -1) return;
		
		try
		{
            JSONParser jParser = new JSONParser();
            JSONObject json = jParser.getJSONFromUrl(u.getUploadUrl(AdminActivity.this) + "?p=participants");

			try {
				JSONArray participants = null;
				participants = json.getJSONArray("participants");

				SQLiteDatabase myDB= null;
				myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);

				//prvo backup
				myDB.execSQL("drop table if exists participant_backup;");
				myDB.execSQL("create table participant_backup as select * from participant");
				//staviti na admin->postavke neki checkbox za vratiti prijašnje stanje (npr. ako pospremim neke trkaèe pa ponovo idem na 
				//download pa mi ih izbriše)
				myDB.execSQL("delete from participant");

				//Log.i("INFO", participants.toString(), null);
				
				for(int i = 0; i < participants.length(); i++){
					JSONObject c = participants.getJSONObject(i);
					saveParticipant(c.getInt("id"), c.getString("per_nam"), c.getString("per_sur"), c.getString("per_shi"), 
							c.getString("per_yea"), c.getString("per_sex"), c.getString("per_email"), c.getString("per_mob"), 
							c.getString("per_clu"), c.getString("per_transfer"));
				}
				
				myDB.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		catch (Exception e) 
		{
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}
	}
	
    private void saveParticipant(int id, String per_nam, String per_sur, String per_shi, String per_yea, String per_sex, 
 		   String per_email, String per_mob, String per_clu, String per_transfer) 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.insertParticipant(id, per_nam, per_sur, per_shi, per_yea, per_sex, per_email, per_mob, per_clu, per_transfer);
    } 

	public void downloadRaces()
	{
		try
		{
            JSONParser jParser = new JSONParser();
            util u = new util();
            JSONObject json = jParser.getJSONFromUrl(u.getUploadUrl(AdminActivity.this) + "?p=races");

			try {
				JSONArray races = null;
				races = json.getJSONArray("races");
			 
				SQLiteDatabase myDB= null;
				myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
				
				//prvo backup
				myDB.execSQL("drop table if exists race_backup;");
				myDB.execSQL("create table race_backup as select * from race");
				//staviti na admin->postavke neki checkbox za vratiti prijašnje stanje (npr. ako pospremim neke trkaèe pa ponovo idem na 
				//download pa mi ih izbriše)
				myDB.execSQL("delete from race");
			
				for(int i = 0; i < races.length(); i++){
					JSONObject c = races.getJSONObject(i);
					saveRace(c.getInt("id"), c.getString("rac_nam"), c.getString("rac_chrono"));
				}
				
				myDB.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		catch (Exception e) 
		{
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}
	}
	
    private void saveRace(int id, String rac_nam, String rac_chrono) 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.insertRace(id, rac_nam, rac_chrono);
    } 

	public void downloadRegistrations()
	{
		try
		{
            JSONParser jParser = new JSONParser();
            util u = new util();
            JSONObject json = jParser.getJSONFromUrl(u.getUploadUrl(AdminActivity.this) + "?p=registrations");

			try {
				JSONArray registrations = null;
				registrations = json.getJSONArray("registrations");
			 
				SQLiteDatabase myDB= null;
				myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);

				//prvo backup
				myDB.execSQL("drop table if exists race_reg_backup;");
				myDB.execSQL("create table race_reg_backup as select * from race_reg");
				//staviti na admin->postavke neki checkbox za vratiti prijašnje stanje (npr. ako pospremim neke trkaèe pa ponovo idem na 
				//download pa mi ih izbriše)
				myDB.execSQL("delete from race_reg");
			
				for(int i = 0; i < registrations.length(); i++){
					JSONObject c = registrations.getJSONObject(i);
					saveRegistration(c.getInt("rac_id"), c.getString("per_id"), c.getString("st_num"), c.getString("st_transfer"));
				}
				
				myDB.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		catch (Exception e) 
		{
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}
	}
	
    private void saveRegistration(int rac_id, String per_id, String st_num, String st_transfer) 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.insertRegistration(rac_id, per_id, st_num, st_transfer);
    } 
    
	public void downloadResults()
	{
        util u = new util();
		String poruka = u.upload(AdminActivity.this, "results_backup", getJsonResults(true, "results_backup"));
		if (poruka.indexOf("uspješno") == -1) return;
		
		try
		{
            JSONParser jParser = new JSONParser();
            JSONObject json = jParser.getJSONFromUrl(u.getUploadUrl(AdminActivity.this) + "?p=results");

			try {
				JSONArray results = null;
				results = json.getJSONArray("results");
			 
				SQLiteDatabase myDB= null;
				myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);

				//prvo backup
				myDB.execSQL("drop table if exists race_result_backup;");
				myDB.execSQL("create table race_result_backup as select * from race_result");
				//staviti na admin->postavke neki checkbox za vratiti prijašnje stanje (npr. ako pospremim neke trkaèe pa ponovo idem na 
				//download pa mi ih izbriše)
				//myDB.execSQL("delete from race_result");
			
				for(int i = 0; i < results.length(); i++){
					JSONObject c = results.getJSONObject(i);
					saveResult(c.getInt("rac_id"), c.getInt("st_num"), c.getString("res_fin_time"), c.getLong("res_fin_time_sec"), c.getString("res_typ"), c.getString("res_time"), c.getString("res_start"));
				}
				
				myDB.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		catch (Exception e) 
		{
			Log.e("Error", "Error", e);
			e.printStackTrace();
		}
	}
	
    private void saveResult(int rac_id, int st_num, String res_time, long res_sec, String res_typ, String res_dt, String res_start) 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.insertResult(rac_id, st_num, res_time, res_sec, res_typ, res_dt, res_start);
    } 
    
    private class UploadTask extends AsyncTask<String, Void, String>
    {
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected String doInBackground(String... urls) 
        {
        	String poruka = "";
        	
        	util u = new util();
            if(u.isConnected(AdminActivity.this))
            {
            	if (upload == 0) poruka = u.upload(AdminActivity.this, "clubs", getJsonClubs());
            	else if (upload == 1) 
            	{
            		poruka = u.upload(AdminActivity.this, "participants", getJsonParticipants("participants"));
            		poruka = u.upload(AdminActivity.this, "registrations", getJsonRegistrations());
            	}
            	else if (upload == 2) u.upload(AdminActivity.this, "results", getJsonResults(false, "results"));
            	else if (upload == 3) 
        		{
            		poruka = u.upload(AdminActivity.this, "clubs", getJsonClubs());
            		poruka = u.upload(AdminActivity.this, "participants", getJsonParticipants("participants"));
            		poruka = u.upload(AdminActivity.this, "registrations", getJsonRegistrations());
            		poruka = u.upload(AdminActivity.this, "results", getJsonResults(false, "results"));
        		}
            	
    			if (((CheckBox) findViewById(R.id.chkProcess)).isChecked()) 
    			{
    				poruka = u.upload(AdminActivity.this, "process", "{\"type\": \"process\", \"race\": " + idRace + "}");
    			}
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
    
    public void uploadWS()
    {
    	UploadTask task = new UploadTask();
        task.execute();
    }
	
	public String getJsonClubs()
	{
		String json = "";
		JSONObject clubs = new JSONObject();
		
		try 
		{  
			JSONObject club;
			clubs.accumulate("type", "clubs");
			
			SQLiteDatabase myDB= null;
			myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
			Cursor c = myDB.rawQuery("SELECT * FROM club where clu_transfer = 'U' or clu_transfer = 'M'" , null);
			
			int iid = c.getColumnIndex("id");
			int iname = c.getColumnIndex("clu_nam");
			int it = c.getColumnIndex("clu_transfer");
		  
			if (c.moveToFirst()) {
				do 
				{
					club = new JSONObject();
					String Name = c.getString(iname);
					int id = c.getInt(iid);
					String transfer = c.getString(it);
					
					club.accumulate("id", id);
					club.accumulate("clu_nam", Name);
					club.accumulate("clu_transfer", transfer);
					
					clubs.accumulate("clubs", club);
				}
				while(c.moveToNext());
			}
			
			c.close();
			myDB.close();

			//treba praznina jer inaèe ne prihvaæa json bez []
			clubs.accumulate("clubs", "");
			json = clubs.toString();
		}
		catch (Exception e) 
		{
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
			e.printStackTrace();
		}

		return json;
	}
	
	public String getJsonParticipants(String type)
	{
		String json = "";     
		JSONObject participants = new JSONObject();

		try 
		{  
			JSONObject participant;
			participants.accumulate("type", type);
			
			SQLiteDatabase myDB= null;
			myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
			Cursor c = myDB.rawQuery("SELECT * FROM participant where per_transfer = 'U' or per_transfer = 'M'" , null);
			
			int iid = c.getColumnIndex("id");
			int iname = c.getColumnIndex("per_nam");
			int isurname = c.getColumnIndex("per_sur");
			int iemail = c.getColumnIndex("per_email");
			int imob = c.getColumnIndex("per_mob");
			int isex = c.getColumnIndex("per_sex");
			int ishirt = c.getColumnIndex("per_shi");
			int iyear = c.getColumnIndex("per_yea");
			int iclub = c.getColumnIndex("per_clu");
			int it = c.getColumnIndex("per_transfer");
		  
			if (c.moveToFirst()) {
				do 
				{
					participant = new JSONObject();
					String Name = c.getString(iname);
					String SurName = c.getString(isurname);
					String Email = c.getString(iemail);
					String Mob = c.getString(imob);
					String Sex = c.getString(isex);
					String Shirt = c.getString(ishirt);
					String Year = c.getString(iyear);
					String Club = c.getString(iclub).toLowerCase().equals("null") ? "" : c.getString(iclub).toLowerCase();
					int id = c.getInt(iid);
					String transfer = c.getString(it);
					
					participant.accumulate("id", id);
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
				}
				while(c.moveToNext());
			}
			
			c.close();
			myDB.close();

			//treba praznina jer inaèe ne prihvaæa json bez []
			participants.accumulate("participants", "");
			json = participants.toString();
            Log.i("JSON UPLOAD", json, null);
		}
		catch (Exception e) 
		{
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
			e.printStackTrace();
		}

		return json;
	}

	public String getJsonRegistrations()
	{
		String json = "";
		JSONObject registrations = new JSONObject();
		
		try 
		{  
			JSONObject reg;
			registrations.accumulate("type", "registrations");
			
			SQLiteDatabase myDB= null;
			myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
			Cursor c = myDB.rawQuery("SELECT * FROM race_reg where st_transfer = 'U' or st_transfer = 'M'" , null);
			
			int iid = c.getColumnIndex("rac_id");
			int iper = c.getColumnIndex("per_id");
			int ist_num = c.getColumnIndex("st_num");
			int it = c.getColumnIndex("st_transfer");
		  
			if (c.moveToFirst()) {
				do 
				{
					reg = new JSONObject();
					int PerId = c.getInt(iper);
					int StNum = c.getInt(ist_num);
					int id = c.getInt(iid);
					String transfer = c.getString(it);
					
					reg.accumulate("id", id);
					reg.accumulate("per_id", PerId);
					reg.accumulate("st_num", StNum);
					reg.accumulate("st_transfer", transfer);
					
					registrations.accumulate("registrations", reg);
				}
				while(c.moveToNext());
			}
			
			c.close();
			myDB.close();

			//treba praznina jer inaèe ne prihvaæa json bez []
			registrations.accumulate("registrations", "");
			json = registrations.toString();
            Log.i("JSON UPLOAD", json, null);
		}
		catch (Exception e) 
		{
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
			e.printStackTrace();
		}
		
		return json;
	}

	public String getJsonResults(boolean all, String type)
	{
		String json = "";
		JSONObject results = new JSONObject();
		
		try 
		{  
			JSONObject result;
			results.accumulate("type", type);
			
			SQLiteDatabase myDB= null;
			myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
			String query = "SELECT * FROM race_result " + (all ? "" : " where rac_id = " + idRace);
			Cursor c = myDB.rawQuery(query , null);
	
			int iid = c.getColumnIndex("id");
			int ist_num = c.getColumnIndex("st_num");
			int iresDT = c.getColumnIndex("res_dt");
			int iresDTOrg = c.getColumnIndex("res_dt_org");
			int iresTime = c.getColumnIndex("res_time");
			int iresTimeOrg = c.getColumnIndex("res_time_org");
			int iresSec = c.getColumnIndex("res_sec");
			int iresSecOrg = c.getColumnIndex("res_sec_org");
			int iresStart = c.getColumnIndex("res_start");
			int iresStartOrg = c.getColumnIndex("res_start_org");
			int iresRace = c.getColumnIndex("rac_id");
		  
			if (c.moveToFirst()) {
				do 
				{
					result = new JSONObject();
					int id = c.getInt(iid);
					int StNum = c.getInt(ist_num);
					int race = c.getInt(iresRace);
					String resDT = c.getString(iresDT);
					String resDTOrg = c.getString(iresDTOrg);
					String resTime = c.getString(iresTime);
					String resTimeOrg = c.getString(iresTimeOrg);
					String resStart = c.getString(iresStart);
					String resStartOrg = c.getString(iresStartOrg);
					float resSec = c.getLong(iresSec) / 1000;
					float resSecOrg = c.getLong(iresSecOrg) / 1000;

					result.accumulate("rac_id", (all ? race: idRace));
					result.accumulate("st_num", StNum);
					result.accumulate("res_time", resDT);
					result.accumulate("res_time_org", resDTOrg);
					result.accumulate("res_fin_time", resTime);
					result.accumulate("res_fin_time_org", resTimeOrg);
					result.accumulate("res_fin_time_sec", resSec);
					result.accumulate("res_fin_time_sec_org", resSecOrg);
					result.accumulate("res_start", resStart);
					result.accumulate("res_start_org", resStartOrg);
					result.accumulate("res_mob_id", id);
					
					results.accumulate("results", result);
				}
				while(c.moveToNext());
				c.close();
				myDB.close();
				
				//treba praznina jer inaèe ne prihvaæa json bez []
				results.accumulate("results", "");
				json = results.toString();
	            Log.i("JSON UPLOAD", json, null);
			}
		}
		catch (Exception e) 
		{
            Log.e("Error", "Greška prilikom pripreme podataka za upload\n", e);
			e.printStackTrace();
		}
		
		return json;
	}
}