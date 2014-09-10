package packageKonj.namespace;

import android.app.Activity;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.util.SparseArray;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;

public class RaceRegistrationActivity extends Activity {
	private int idRace;
    private TableLayout queryTableLayout; 
    SparseArray<String> registered = new SparseArray<String>();
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.race_reg);

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
            
            queryTableLayout = (TableLayout) findViewById(R.id.queryTableLayout); 

            getRegistered();  
                   
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
    
    private void refreshButtons(SparseArray<String> registered) 
    {
    	for (int i = 0; i < registered.size(); i++) 
    	{
 		    String Value = registered.valueAt(i);
 		    int Key = registered.keyAt(i);
    		makeTagGUI(Value, Key);
    	}
    } 
    
    private void makeTagGUI(String tag, int index)
    {
       LayoutInflater inflater = (LayoutInflater) getSystemService(
          Context.LAYOUT_INFLATER_SERVICE);

       View newTagView = inflater.inflate(R.layout.race_reg_view, null);
       
       TextView tvName = (TextView) newTagView.findViewById(R.id.nameTextView);
       tvName.setText(tag); 
		
	   TextView tvStartNumber = (TextView) newTagView.findViewById(R.id.surnameTextView);
	   tvStartNumber.setText(String.valueOf(index)); 
       
       queryTableLayout.addView(newTagView);
    }

    private class getRegisteredHelper extends AsyncTask<String, Void, SparseArray<String>> 
    {
    	SQLiteDatabase myDB= null;
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected SparseArray<String> doInBackground(String... urls) {
        	try {
                try {
                    myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                    Cursor c = myDB.rawQuery("SELECT rr.st_num, p.per_nam, p.per_sur FROM race_reg rr" + 
					" inner join participant p on rr.per_id=p.id " + 
					" where rr.rac_id = " + idRace, null);
					
                    int ist_num = c.getColumnIndex("st_num");
                    int iname = c.getColumnIndex("per_nam");
                    int isurname = c.getColumnIndex("per_sur");
                  
                    if (c.moveToFirst()) {
                     do {
                      String Name = c.getString(iname);
                      String Surname = c.getString(isurname);
                      int st_num = c.getInt(ist_num);
					  Name = (Name + Surname).length() > 25 ? Name.substring(0, 1) + ". " + Surname : Name + " " + Surname;
                      registered.put(st_num, Name);
                     }while(c.moveToNext());
                    }
                    
                    c.close();
                    
                } catch (Exception e) {
                    e.printStackTrace();
                }
             }
             catch (Exception e) {
            	 Log.e("Error", "Error", e);
                 e.printStackTrace();
             }
          return registered;
       }
      
       @Override
       protected void onPostExecute(SparseArray<String> result) 
       {
	   	    if (result != null) refreshButtons(result); 
            //Toast.makeText(getApplicationContext(),"Completed...", Toast.LENGTH_LONG).show();
        }
    }

    public void getRegistered()
    {
    	getRegisteredHelper task = new getRegisteredHelper();
        task.execute();
    }
}