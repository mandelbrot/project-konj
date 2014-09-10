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

public class ClubsActivity extends Activity {
    private TableLayout queryTableLayout; 
    SparseArray<String> clubs = new SparseArray<String>();
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.clubs);  
        
        new setActivity().execute();    
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 
            queryTableLayout = 
                    (TableLayout) findViewById(R.id.queryTableLayout); 

        	getClubs();
   
            Button newButton = (Button) findViewById(R.id.newButton);
            newButton.setOnClickListener(newButtonListener);   
            
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
    
    private void refreshButtons(SparseArray<String> clubs) 
    {
       // store saved tags in the tags array
       //String[] tags = clubs.keySet().toArray(new String[0]); 
       //Arrays.sort(tags, String.CASE_INSENSITIVE_ORDER); // sort by tag

/*       // if a new tag was added, insert in GUI at the appropriate location
       if (newTag != null)
       {
          makeTagGUI(newTag, Arrays.binarySearch(tags, newTag));
       } // end if
       else // display GUI for all tags
       { */        
          // display all saved searches
    	for (int i = 0; i < clubs.size(); i++) 
    	{
 		    String Value = clubs.valueAt(i);
 		    int Key = clubs.keyAt(i);
    		makeTagGUI(Value, Key);
    	}
       /*for (Map.Entry<Integer, String> entry : clubs) 
       { 
    	   //System.out.println("Key = " + entry.getKey() + ", Value = " + entry.getValue()); 
    	   makeTagGUI(entry.getValue(), entry.getKey());
       } */
       //} 
    }
    
    private void makeTagGUI(String tag, int index)
    {
       LayoutInflater inflater = (LayoutInflater) getSystemService(
          Context.LAYOUT_INFLATER_SERVICE);

       View newTagView = inflater.inflate(R.layout.tag_view, null);
       
       TextView tvName = (TextView) newTagView.findViewById(R.id.nameTextView);
       tvName.setText(tag); 
       tvName.setTag(index); 
       
       tvName.setOnClickListener(onClickNameTextViewListener); 

       Button newDeleteButton = 
          (Button) newTagView.findViewById(R.id.deleteButton); 
       newDeleteButton.setOnClickListener(deleteButtonListener);

       //queryTableLayout.addView(newTagView, index);
       queryTableLayout.addView(newTagView);
    } 

    private class getClubsHelper extends AsyncTask<String, Void, SparseArray<String>> 
    {
    	SQLiteDatabase myDB= null;
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected SparseArray<String> doInBackground(String... urls) 
        {
            try {
                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                Cursor c = myDB.rawQuery("SELECT * FROM club" , null);
                
                int iid = c.getColumnIndex("id");
                int iname = c.getColumnIndex("clu_nam");
             
                if (c.moveToFirst()) {
                 do {
                  String Name = c.getString(iname);
                  int id = c.getInt(iid);
                  //Data = Data +Name+"/"+id+"\n";
                  Name = Name.length() > 25 ? Name.substring(0, 25) + "..."  : Name;
                  clubs.put(id, Name);
                 }while(c.moveToNext());
                }
                
                c.close();
                myDB.close();
            } 
            catch (Exception e) 
            {
                e.printStackTrace();
           	    Log.e("Error", "Error", e);
            }
           return clubs;
        }
      
        @Override
        protected void onPostExecute(SparseArray<String> result) 
        {
	   	    if (result != null) refreshButtons(result); 
        }
    }

    public void getClubs() 
    {
    	getClubsHelper task = new getClubsHelper();
        task.execute();
    }
    
    public OnClickListener newButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
           Intent i = new Intent(ClubsActivity.this, ClubActivity.class);
           startActivity(i);
       } 
    };

    public OnClickListener onClickNameTextViewListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   TableRow buttonTableRow = (TableRow) v.getParent();
           
           int idClub = Integer.parseInt(((TextView) buttonTableRow.findViewById(R.id.nameTextView)).getTag().toString());

           Intent i = new Intent(ClubsActivity.this, ClubActivity.class);
           i.putExtra("idClub", idClub);
           startActivity(i);
       } 
    };

    public OnClickListener deleteButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(final View v) 
       {
    	   final TableRow buttonTableRow = (TableRow) v.getParent();
    	   final TableLayout tl = (TableLayout) buttonTableRow.getParent();
    	   final String nameClub = ((TextView) buttonTableRow.findViewById(R.id.nameTextView)).getText().toString();
    	   
    	   AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(ClubsActivity.this);
    	   alertDialog2.setTitle("Potvrdi brisanje...");
    	   alertDialog2.setMessage("Brisanje kluba '" + nameClub + "'?");

    	   alertDialog2.setPositiveButton("DA",
    		        new DialogInterface.OnClickListener() {
    		            public void onClick(DialogInterface dialog, int which) {
    		                String idClub = ((TextView) buttonTableRow.findViewById(R.id.nameTextView)).getTag().toString();
 
    		                deleteClub(Integer.parseInt(idClub));
    		                
    		         	    tl.removeView(buttonTableRow);
    		         	    
    		                Toast.makeText(getApplicationContext(),
    		                        "Klub " + nameClub + " obrisan!", Toast.LENGTH_SHORT).show();
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
    
    private void deleteClub(int id) 
    {
        DatabaseConnector dc = new DatabaseConnector(this);
        dc.deleteClub(id);
    } 
}