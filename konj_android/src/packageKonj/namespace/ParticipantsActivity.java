package packageKonj.namespace;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.util.SparseArray;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;

public class ParticipantsActivity extends Activity {
    private TableLayout queryTableLayout; 
    SparseArray<String> participants = new SparseArray<String>();
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.participants);

        new setActivity().execute();       
    }

    private class setActivity extends AsyncTask<Void, Void, Void> 
    { 
        @Override 
        protected Void doInBackground(Void... params) { 

            queryTableLayout = (TableLayout) findViewById(R.id.queryTableLayout); 

            getParticipants();
                   
            Button newButton = (Button) findViewById(R.id.newButton);
            newButton.setOnClickListener(newButtonListener);   
            
            return null;
        } 

        @Override 
        protected void onPostExecute(Void result) { 
            Log.i("LOGGER", "...Done doInBackground loadList");  
        } 
    }  
    
    private void refreshButtons(SparseArray<String> participants) 
    {
    	for (int i = 0; i < participants.size(); i++) 
    	{
 		    String Value = participants.valueAt(i);
 		    int Key = participants.keyAt(i);
    		makeTagGUI(Value, Key);
    	}
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

       queryTableLayout.addView(newTagView);
    }

    private class getParticipantsHelper extends AsyncTask<String, Void, SparseArray<String>> 
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
                    Cursor c = myDB.rawQuery("SELECT * FROM participant order by per_sur, per_nam" , null);
                    
                    int iid = c.getColumnIndex("id");
                    int iname = c.getColumnIndex("per_nam");
                    int isurname = c.getColumnIndex("per_sur");
                  
                    if (c.moveToFirst()) {
                     do {
                      String Name = c.getString(iname);
                      String Surname = c.getString(isurname);
                      int id = c.getInt(iid);;
                      Name = (Name + Surname).length() > 25 ? Name.substring(0, 1) + ". " + Surname : Name + " " + Surname;
                      participants.put(id, Name);
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
          return participants;
       }
      
       @Override
       protected void onPostExecute(SparseArray<String> result) 
       {
	   	    if (result != null) refreshButtons(result); 
            //Toast.makeText(getApplicationContext(),"Completed...", Toast.LENGTH_LONG).show();
       }
    }

    public void getParticipants()
    {
    	getParticipantsHelper task = new getParticipantsHelper();
        task.execute();
    }
    
    public OnClickListener newButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v)  
       {
           Intent i = new Intent(ParticipantsActivity.this, ParticipantActivity.class);
           i.putExtra("idParticipant", 0);
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
           
           int idParticipant = Integer.parseInt(tv.getTag().toString());

           Intent i = new Intent(ParticipantsActivity.this, ParticipantActivity.class);
           i.putExtra("idParticipant", idParticipant);
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
    	   String nameParticipant = tv.getText().toString();
    	   
    	   AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(ParticipantsActivity.this);
    	   alertDialog2.setTitle("Potvrdi brisanje...");
    	   alertDialog2.setMessage("Brisanje natjecatelja '" + nameParticipant + "'?");

    	   alertDialog2.setPositiveButton("DA",
    		        new DialogInterface.OnClickListener() {
    		            public void onClick(DialogInterface dialog, int which) {
    		         	    TableRow buttonTableRow = (TableRow) v.getParent();
    		        	    TableLayout tl = (TableLayout) buttonTableRow.getParent();
    		        	    TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
    		                String idParticipant = tv.getTag().toString();
    		                
    		            	//obriši iz baze
    		                SQLiteDatabase myDB= null;
    		                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
    		 	            String sql = "delete from participant where id = " + idParticipant; 
    		                myDB.execSQL(sql);
    		                myDB.close();
    		                
    		         	    String nameParticipant = tv.getText().toString();
    		         	    tl.removeView(buttonTableRow);
    		                Toast.makeText(getApplicationContext(),
    		                        "Osoba " + nameParticipant + " obrisana!", Toast.LENGTH_SHORT).show();
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