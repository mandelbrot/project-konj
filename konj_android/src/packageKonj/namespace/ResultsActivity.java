package packageKonj.namespace;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.util.SparseArray;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

public class ResultsActivity extends Activity {
	int idRace;
    private TableLayout queryTableLayout; 
	SparseArray<String> races = new SparseArray<String>();
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.results);

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

            getResults(); 
                   
            Button newButton = (Button) findViewById(R.id.newButton);
            newButton.setOnClickListener(newButtonListener);  
            
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
    
    private void refreshButtons(SparseArray<String> races) 
    {
    	for (int i = 0; i < races.size(); i++) 
    	{
 		    String Value = races.valueAt(i);
 		    int Key = races.keyAt(i);
    		makeTagGUI(Value, Key);
    	}
    } 
    
    private void makeTagGUI(String tag, int index)
    {
       LayoutInflater inflater = (LayoutInflater) getSystemService(
          Context.LAYOUT_INFLATER_SERVICE);

       View newTagView = inflater.inflate(R.layout.race_view, null);
       
       TextView tvName = (TextView) newTagView.findViewById(R.id.nameTextView);
       tvName.setText(tag); 
       tvName.setTag(index); 
       
       tvName.setOnClickListener(onClickNameTextViewListener);

       Button newDeleteButton = (Button) newTagView.findViewById(R.id.deleteButton); 
       newDeleteButton.setOnClickListener(deleteButtonListener);
       
       //queryTableLayout.addView(newTagView, index);
       queryTableLayout.addView(newTagView);
    }

    private class getResultsHelper extends AsyncTask<String, Void, SparseArray<String>> 
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
                    Cursor c = myDB.rawQuery("SELECT rr.*,p.per_nam,p.per_sur FROM race_result rr "+
                    		" inner join race_reg rreg on rr.st_num=rreg.st_num and rr.rac_id=rreg.rac_id" +
                    		" left join participant p on rreg.per_id=p.id where rr.rac_id = " + idRace, null);
                    
                    int iid = c.getColumnIndex("id");
                    int ist_num = c.getColumnIndex("st_num");
                    int iname = c.getColumnIndex("per_nam");
                    int isurname = c.getColumnIndex("per_sur");
                  
                    if (c.moveToFirst()) {
                     do {
                         String Name = c.getString(iname);
                         String Surname = c.getString(isurname);
                         String StNum = c.getString(ist_num);
                         int id = c.getInt(iid);
   					  	 Name = (StNum + "-" + Name + Surname).length() > 25 ? 
   					  			 StNum + "-" + Name.substring(0, 1) + ". " + Surname : 
   					  		     StNum + "-" + Name + " " + Surname;
                         races.put(id, Name);
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
          return races;
       }
      
       @Override
       protected void onPostExecute(SparseArray<String> result) 
       {
	   	    if (result != null) refreshButtons(result); 
            //Toast.makeText(getApplicationContext(),"Completed...", Toast.LENGTH_LONG).show();
        }
    }

    public void getResults()
    {
    	getResultsHelper task = new getResultsHelper();
        task.execute();
    }
    
    public OnClickListener newButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(ResultsActivity.this, ResultActivity.class);
           i.putExtra("idResult", 0);
           startActivity(i);
       } 
    };

    public OnClickListener onClickNameTextViewListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   TableRow buttonTableRow = (TableRow) v.getParent();
           TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
           
           int idResult = Integer.parseInt(tv.getTag().toString());
           
           Intent i = new Intent(ResultsActivity.this, ResultActivity.class);
           i.putExtra("idResult", idResult);
           startActivity(i);
       } 
    };

    public OnClickListener deleteButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(final View v) 
       {
    	   TableRow buttonTableRow = (TableRow) v.getParent();
    	   TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
    	   String nameRace = tv.getText().toString();
    	   
    	   AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(ResultsActivity.this);
    	   alertDialog2.setTitle("Potvrdi brisanje...");
    	   alertDialog2.setMessage("Brisanje rezultata '" + nameRace + "'?");

    	   alertDialog2.setPositiveButton("DA",
		        new DialogInterface.OnClickListener() {
		            public void onClick(DialogInterface dialog, int which) {
		         	    TableRow buttonTableRow = (TableRow) v.getParent();
		        	    TableLayout tl = (TableLayout) buttonTableRow.getParent();
		        	    TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
		                String idResult = tv.getTag().toString();
		                
		                SQLiteDatabase myDB= null;
		                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
		 	            String sql = "delete from race_result where id = " + idResult; 
		                myDB.execSQL(sql);
		                myDB.close();
		                
		         	    String nameRace = tv.getText().toString();
		         	    tl.removeView(buttonTableRow);
		                Toast.makeText(getApplicationContext(),
		                        "Rezultat '" + nameRace + "' obrisan!", Toast.LENGTH_SHORT).show();
		            }
		        });
    	   alertDialog2.setNegativeButton("NE",
			   new DialogInterface.OnClickListener() {
    		   	   public void onClick(DialogInterface dialog, int which) {
    		                //Toast.makeText(getApplicationContext(), "You clicked on NO", Toast.LENGTH_SHORT).show();
    		                dialog.cancel();
    		            }
    		        });
    	   alertDialog2.show();
       } 
    };
}