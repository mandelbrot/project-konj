package packageKonj.namespace;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

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
import android.widget.EditText;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

public class TimerActivity extends Activity {
	int idRace;
    private TableLayout queryTableLayout; 
    SparseArray<String> races = new SparseArray<String>();
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.timer);
        
    	idRace = ((MyApp)getApplication()).getIdRace();

    	util u = new util();
        if(!u.getRaceChrono(this, idRace))
        {
    		EditText ev = (EditText) findViewById(R.id.startParticipantEditText);
    		ev.setVisibility(View.GONE);
    		Button timerButton = (Button) findViewById(R.id.startParticipantButton);
    		timerButton.setVisibility(View.GONE);
        }
        
        new setActivity().execute(); 
        
 	    if(idRace == 0)
 	    {
            Toast.makeText(getApplicationContext(), "Nije postavljena utrka. Idi na meni 'Utrke' i odaberi utrku!", Toast.LENGTH_SHORT).show();
 		    return;
 	    }
    }

    private class setActivity extends AsyncTask<Void, Void, SparseArray<String>> 
    { 
        @Override 
        protected SparseArray<String> doInBackground(Void... params) { 
        	SparseArray<String> results = new SparseArray<String>();
        	
            queryTableLayout = (TableLayout) findViewById(R.id.queryTableLayout); 

        	idRace = ((MyApp)getApplication()).getIdRace();

     	    SQLiteDatabase myDB= null;
            myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
            Cursor c = myDB.rawQuery("SELECT  rr.st_num," +
            	" ifnull(p.per_nam,'') as name, ifnull(p.per_sur,'') as surname, rr.res_time " + 
				" FROM race_result rr" +
				" left join race_reg reg on rr.st_num=reg.st_num and reg.rac_id = " + idRace +  
				" left join participant p on reg.per_id=p.id" +
				" where rr.rac_id = " + idRace + " order by rr.res_time", null);
            
            int istNum = c.getColumnIndex("st_num");
            int iname = c.getColumnIndex("name");
            int isurname = c.getColumnIndex("surname");
            int ivreme = c.getColumnIndex("res_time"); 
            int br = 1;
            if (c.moveToFirst()) {
                do {
                 int stNum = c.getInt(istNum);
                 String vreme = c.getString(ivreme);
                 results.put(stNum, br + ". " + getParticipantName(c.getString(iname), c.getString(isurname)) + 
                		 "(" + stNum + ") - " + vreme);
                 br++;
                }while(c.moveToNext());
               }
               
            c.close();
            myDB.close();
            
            Button timerButton = (Button) findViewById(R.id.timerButton);
            timerButton.setOnClickListener(timerButtonListener);   
            
            Button startButton = (Button) findViewById(R.id.startParticipantButton);
            startButton.setOnClickListener(startParticipantButtonListener);  
            
            Button resultButton = (Button) findViewById(R.id.resultButton);
            resultButton.setOnClickListener(resultButtonListener);  
            
            return results;
        } 

        @Override 
        protected void onPostExecute(SparseArray<String> result) { 
	   	    if (result != null) refreshButtons(result); 
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
       
       queryTableLayout.addView(newTagView);
    }

    private class getResultsHelper extends AsyncTask<String, Void, SparseArray<String>> 
    {
    	SQLiteDatabase myDB = null;
        @Override
        protected void onPreExecute() {
             //if you want, start progress dialog here
        }
             
        @Override
        protected SparseArray<String> doInBackground(String... urls) {
        	try {
                try {
                    myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
                    Cursor c = myDB.rawQuery("SELECT * FROM race" , null);
                    
                    int iid = c.getColumnIndex("id");
                    int iname = c.getColumnIndex("rac_nam");
                  
                    if (c.moveToFirst()) {
                     do {
                      String Name = c.getString(iname);
                      int id = c.getInt(iid);
                      Name = Name.length() > 25 ? Name.substring(0, 25) + "..."  : Name;
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

    public OnClickListener timerButtonListener = new OnClickListener()
    {
        @Override
        public void onClick(View v) 
        {
     	    if(idRace == 0)
     	    {
                Toast.makeText(getApplicationContext(), "Nije postavljena utrka. Idi na meni 'Utrke' i odaberi utrku!", Toast.LENGTH_SHORT).show();
     		    return;
     	    }
    	    EditText tv = (EditText) TimerActivity.this.findViewById(R.id.nameEditText);
    	    String noviStart = tv.getText().toString().trim();
    	   
    	    if (noviStart != null && !noviStart.isEmpty())
    	    {
    		    Calendar noviStartCalendar = Calendar.getInstance();

			    DateFormat formatter; 
			    Date startDT = new Date(); 
			    formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			    String poruka = "";
			    try
                {
				    poruka = "Start utrke podešen na: " + formatter.format(startDT);
				    startDT = formatter.parse(noviStart);
                }
			    catch (Exception ex)
			    {
				    poruka = "Krivo upisano vrijeme! Start utrke podešen na:\n" +
	                    formatter.format(startDT)  + "\n" + ex.toString();
			    }
        	    finally
        	    {
	                Toast.makeText(getApplicationContext(), poruka, Toast.LENGTH_LONG).show();
        	    }
    		   
    		    //uzmi trenutni start
    		    SQLiteDatabase myDB= null;
    		    myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
   			    Cursor c = myDB.rawQuery("SELECT * FROM race where id=" + idRace , null);

   			    int istart = c.getColumnIndex("rac_start");
   			    int istartL = c.getColumnIndex("rac_start_sec");
   			    String stariStart = "";
   			    long stariStartLong = 0;

   			    if (c.moveToFirst()) {
	   			    do 
	   			    {
	   			        stariStart = c.getString(istart);
	   				    stariStartLong = c.getLong(istartL);
	   			    }
	   			    while(c.moveToNext());
   			    }
   			    else
   			    {
   				    stariStart = noviStart;
   				    try
   				    {
   				    	Date d = formatter.parse(stariStart);
   				    	stariStartLong = d.getTime();
   				    }
   				    catch (Exception ex)
   				    {
   				    	stariStart = formatter.format(noviStartCalendar.getTime());
   	   			  	    stariStartLong = noviStartCalendar.getTimeInMillis();
   				    }
   			    }
   			   
   			    c.close();
   			    myDB.close();  

				//kalibriraj rezultate za utrku koja NIJE na kronometar!!!
				util u = new util();
			    if(!u.getRaceChrono(TimerActivity.this, idRace))
			    {
					myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
					//ako utrka ima kronometar, onda i rezultati imaju res_start pa njih ne gledaj
					//moglo se i staviti da gleda samo rezultate za race.rac_chrono <> 'D'
					c = myDB.rawQuery("SELECT id, res_sec_org FROM race_result where rac_id=" + idRace + 
							" and res_start is not null and trim(res_start) <> ''", null);

					int iid = c.getColumnIndex("id");
					int iresSecOrg = c.getColumnIndex("res_sec_org");
				  
					if (c.moveToFirst()) 
					{
						do 
						{
							int id = c.getInt(iid);
							Long resLongOrg = c.getLong(iresSecOrg);

							long diff = stariStartLong + resLongOrg - noviStartCalendar.getTimeInMillis();

							String vrijemeRucno = u.resultLong2String(diff);
						 
							 //Toast.makeText(getApplicationContext(), String.valueOf(stariStartLong) + "\n" + 
							 //		 String.valueOf(noviStartDT.getTimeInMillis()) + "\n" +  
							 //		 String.valueOf(resLongOrg) + "\n" +
							 //		 String.valueOf(diff), Toast.LENGTH_SHORT).show();
		
							 /*Log.i("LOGGER", "\n");
							 Log.i("LOGGER", String.valueOf(stariStartLong));
							 Log.i("LOGGER", stariStart);
							 Log.i("LOGGER", String.valueOf(noviStartDT.getTimeInMillis()) );
							 Log.i("LOGGER", noviStart);
							 Log.i("LOGGER", String.valueOf(resLongOrg));
							 Log.i("LOGGER", String.valueOf(diff));
							 Log.i("LOGGER", "\n");*/
					   
							 //Toast.makeText(getApplicationContext(), String.valueOf(diff)+ "\n" + vrijemeRucno, Toast.LENGTH_SHORT).show();
						 
							Calendar noviResDT = Calendar.getInstance();
							noviResDT.setTimeInMillis(noviStartCalendar.getTimeInMillis() + diff);  
						 
							String sql;
							sql = "update race_result " +
								" set res_dt = '" + formatter.format(noviResDT.getTime()) + "'," +
								" res_time = '" + vrijemeRucno + "'," +
								" res_sec = " + diff +
								" where id = " + id ; 
							//Toast.makeText(getApplicationContext(), "test " + sql, Toast.LENGTH_LONG).show();
							myDB.execSQL(sql);
						}
						while(c.moveToNext());
					  
						Toast.makeText(getApplicationContext(), "Rezultati uspješno kalibrirani!", Toast.LENGTH_SHORT).show();
					}
					
					c.close();
					myDB.close(); 
   				}
	    	}
	    	else
	    	{
    		    Long startLong = startajUtrku();
                Toast.makeText(getApplicationContext(), "Start utrke podešen na: " + 
        		    String.valueOf(startLong), Toast.LENGTH_LONG).show();
	    	}
	
			//zemi vrijeme sa servera i spremi u bazu NA SERVERU (treba to uopæe?)
	    	   
	        tv.setText("");
        } 
    };
  
    public OnClickListener startParticipantButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   if(idRace == 0)
    	   {
               Toast.makeText(getApplicationContext(), "Nije postavljena utrka. Idi na meni 'Utrke' i odaberi utrku!", Toast.LENGTH_SHORT).show();
    		   return;
    	   }
    	    
    	   EditText et = (EditText) TimerActivity.this.findViewById(R.id.startParticipantEditText);
    	   String id = et.getText().toString().trim();
    	   int stNum = 0;

    	   String[] parts = id.split(",");
    	   List<Integer> stNums = new ArrayList<Integer>();
    	   
    	   for(int i = 0; i < parts.length;i++)
    	   {
	    	   try 
	    	   {
	    		   stNum = Integer.parseInt(parts[i]);
	    	   } 
	    	   catch(NumberFormatException nfe) 
	    	   {
	               Toast.makeText(getApplicationContext(), "Upiši cijeli broj kao id!", Toast.LENGTH_SHORT).show();
	               et.setText("");
	               et.requestFocus();
	               return;
	    	   } 
	    	   
	    	   if (stNum < 1)
	    	   {
	    		   Toast.makeText(getApplicationContext(), "Upiši broj kao id!", Toast.LENGTH_SHORT).show();
	               et.setText("");
	               et.requestFocus();
	               return;
	    	   }
	    	   
	    	   stNums.add(stNum);
    	   }

           SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    	   
           long startLong = getStart(idRace);
          
    	   if(startLong == 0)
    	   { 		   
               startLong = startajUtrku();
    	   }

           Calendar startDateTime = Calendar.getInstance();
           long cilj = startDateTime.getTimeInMillis();
           String startString = formatter.format(new Date(cilj));           
           
           for(int i = 0; i < stNums.size(); i++)
           { 
	    	   String sql = "insert into race_result(id,rac_id,st_num,res_start,res_start_org,res_dt,res_dt_org,res_time,res_time_org,res_sec,res_sec_org) " +
	    		   " values (null," + idRace + "," + stNums.get(i) + ","+
	    		   "'" + startString + "','" + startString + "',null,null,null,null,null,null)"; 
  
	           if(resultExists(idRace, stNums.get(i)))
	           {
	        	   sql = "update race_result set res_start = '" + startString + "', res_start_org = '" + startString + "'" + 
	        	       " where rac_id = " + idRace + " and st_num = " + stNums.get(i);
	           }
	           
	           //Toast.makeText(getApplicationContext(), sql, Toast.LENGTH_SHORT).show();
	
			   SQLiteDatabase myDB= null;
		       myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
			   myDB.execSQL(sql);
           }

			Log.i("LOGGER", "3", null);
			
		   et.setText("");
           et.requestFocus();
       } 
    };
    
    public OnClickListener resultButtonListener = new OnClickListener()
    {
       @Override
       public void onClick(View v) 
       {
    	   if(idRace == 0)
    	   {
               Toast.makeText(getApplicationContext(),
                       "Nije postavljena utrka. Idi na meni 'Utrke' i odaberi utrku!", Toast.LENGTH_SHORT).show();
    		   return;
    	   }

    	   EditText et = (EditText) TimerActivity.this.findViewById(R.id.resultEditText);
    	   String id = et.getText().toString().trim();
    	   
    	   String[] parts = id.split(",");
    	   List<Integer> stNums = new ArrayList<Integer>();
    	   int stNum = 0;
    	   
    	   for(int i = 0; i < parts.length;i++)
    	   {
	    	   try 
	    	   {
	    		   stNum = Integer.parseInt(parts[i]);
	    	   } 
	    	   catch(NumberFormatException nfe) 
	    	   {
	               Toast.makeText(getApplicationContext(), "Upiši cijeli broj kao id!", Toast.LENGTH_SHORT).show();
	               et.setText("");
	               et.requestFocus();
	               return;
	    	   } 
	    	   
	    	   if (stNum < 1)
	    	   {
	    		   Toast.makeText(getApplicationContext(), "Upiši broj kao id!", Toast.LENGTH_SHORT).show();
	               et.setText("");
	               et.requestFocus();
	               return;
	    	   }
	    	   
	    	   stNums.add(stNum);
    	   }
    	   
           SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    	   
           long startLong;
    	   List<Long> startLongs = new ArrayList<Long>();
       	   util u = new util();
       	   
           if(u.getRaceChrono(TimerActivity.this, idRace))
           {
        	   for(int i = 0; i < stNums.size(); i++)
        	   {
        		   startLongs.add(getParticipantStart(idRace, stNums.get(i)));
        	   }
           }
           else
           {
               startLong = getStart(idRace);
               
        	   if(startLong == 0)
        	   { 		   
                   startLong = startajUtrku();
        	   }
        	   
        	   for(int i = 0; i < stNums.size(); i++)
        	   {
        		   startLongs.add(startLong);
        	   }
           }
           
           Calendar endDateTime = Calendar.getInstance();

		   SQLiteDatabase myDB = null;
	       myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
	       
    	   List<String> vrijemeRucno = new ArrayList<String>();
	       
           for(int i = 0; i < stNums.size(); i++)
           { 
	           long cilj = endDateTime.getTimeInMillis();
	           long diff = cilj - startLongs.get(i);
	
	           String vrijemeRucnoT = u.resultLong2String(diff);
	           vrijemeRucno.add(vrijemeRucnoT);
	           
	           String startString = formatter.format(new Date(cilj));
           
	           String sql = "insert into race_result(id,rac_id,st_num,res_dt,res_dt_org,res_time,res_time_org,res_sec,res_sec_org) " +
	        		   " values (null," + idRace + "," + stNums.get(i) + ","+
	        		   "'" + startString + "','" + startString + "'," +
	        		   "'" + vrijemeRucnoT + "','" + vrijemeRucnoT + "'," + 
	        		   String.valueOf(diff) + "," + String.valueOf(diff) + ")";  
	           
	           if(resultExists(idRace, stNums.get(i)))
	           {
	        	   sql = "update race_result set res_dt = '" + startString + "', res_dt_org = '" + startString + "'," + 
	        		   "res_time = '" + vrijemeRucnoT + "', res_time_org = '" + vrijemeRucnoT + "'," + 
	        		   "res_sec = " + String.valueOf(diff) + ", res_sec_org = " + String.valueOf(diff) + 
	        	       " where rac_id = " + idRace + " and st_num = " + stNums.get(i);
	           }
	           //Toast.makeText(getApplicationContext(), sql, Toast.LENGTH_SHORT).show();
	
			   myDB.execSQL(sql);
           }
           
           for(int i = 0; i < stNums.size(); i++)
           { 
			   if(!resultExists(idRace, stNums.get(i)))
			   {
		           Cursor c = myDB.rawQuery("SELECT * FROM race_reg reg " + 
		            		" left join participant p on p.id=per_id " + 
		            		" where per_id = " + stNums.get(i) + " and rac_id = " + idRace, null);
		           int inam = c.getColumnIndex("per_nam");
		           int isurnam = c.getColumnIndex("per_sur");
		           String participant = "Bezimeni";
		           if(c.moveToFirst()) participant = getParticipantName(c.getString(inam), c.getString(isurnam));
		           c.close();
		           
		           makeTagGUI(queryTableLayout.getChildCount() + 1 + ". " + participant + " (" + stNums.get(i) + ") - " + vrijemeRucno.get(i), stNums.get(i));
			   }
           }
		   et.setText("");
           et.requestFocus();
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

           Intent i = new Intent(TimerActivity.this, ResultActivity.class);
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
    	   //TableLayout tl = (TableLayout) buttonTableRow.getParent();
    	   TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
    	   String nameRace = tv.getText().toString();
    	   
    	   AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(TimerActivity.this);
    	   alertDialog2.setTitle("Potvrdi brisanje...");
    	   alertDialog2.setMessage("Brisanje rezultata od '" + nameRace + "'?");

    	   alertDialog2.setPositiveButton("DA",
    		        new DialogInterface.OnClickListener() {
    		            public void onClick(DialogInterface dialog, int which) {
    		         	    TableRow buttonTableRow = (TableRow) v.getParent();
    		        	    TableLayout tl = (TableLayout) buttonTableRow.getParent();
    		        	    TextView tv = (TextView) buttonTableRow.findViewById(R.id.nameTextView);
    		                String stNum = tv.getTag().toString();
    		                
    		            	//obriši iz baze
    		                SQLiteDatabase myDB= null;
    		                myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
    		                
    		 	            //još za svaki sluèaj deti negde u bekap
    		                
    		 	            String sql = "delete from race_result where id = " + idRace + " and st_num = "+ stNum;
    		                myDB.execSQL(sql);
    		                myDB.close();
    		                
    		         	    String nameRace = tv.getText().toString();
    		         	    tl.removeView(buttonTableRow);
    		                Toast.makeText(getApplicationContext(),
    		                        "Rezultat od " + nameRace + " obrisan!", Toast.LENGTH_SHORT).show();
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
    
    public Long startajUtrku()
    {
        Calendar startDateTime = Calendar.getInstance();
        Long startLong = startDateTime.getTimeInMillis();
        Toast.makeText(getApplicationContext(), "Start utrke podešen na:\n" +
           		startDateTime.getTime().toString() + "\n" + 
           		String.valueOf(startDateTime.getTimeInMillis()), Toast.LENGTH_LONG).show();
		
        updateRace(startLong);
        
		return startLong;
    }
    
    public void updateRace(long startLong)
    {
        SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String startString = formatter.format(new Date(startLong));
        String sql;
        sql = "update race " +
            " set rac_start = '" + startString + "'," +
            " rac_start_sec = '" + startLong + "'" +
            " where id=" + idRace ; 
		SQLiteDatabase myDB= null;
        myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
		myDB.execSQL(sql);
    }
    
    public long getStart(int idRace)
    {
	   SQLiteDatabase myDB= null;
       myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
       Cursor c = myDB.rawQuery("SELECT rac_start_sec FROM race " + 
       		" where id = " + idRace, null);
       int istart = c.getColumnIndex("rac_start_sec");
       long startLong = 0;
       if(c.moveToFirst()) startLong = c.getLong(istart);
       c.close();
       
       return startLong;
    }
    
    public long getParticipantStart(int idRace, int stNum)
    {
	    SQLiteDatabase myDB= null;
        myDB = openOrCreateDatabase("konj", MODE_PRIVATE, null);
        Cursor c = myDB.rawQuery("SELECT res_start FROM race_result " + 
        		" where rac_id = " + idRace + " and st_num = " + stNum, null);
        int istart = c.getColumnIndex("res_start");
        String partcipantStart = "";
        long startLong;
        if(c.moveToFirst()) partcipantStart = c.getString(istart);
        else
        {
      	    startLong = getStart(idRace);
        }
        c.close();
        
	    DateFormat formatter; 
	    formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

	    try
	    {
	    	Date d = formatter.parse(partcipantStart);
	    	startLong = d.getTime();
	    }
	    catch (Exception ex)
	    {
	    	startLong = getStart(idRace);
	    }
    
        return startLong;
    }
   
    private String getParticipantName(String name, String surname)
    {
       String participant = "Bezimeni";
       if ((name.trim() + surname.trim()).length() > 15) 
       {
    	   participant = name.substring(1, 1) + "." + surname;
       }
       else if((name.trim() + surname.trim()).length() > 1) 
       {
    	   participant = name + " " + surname;
       }
       return participant;
    }
    
    private boolean resultExists(int idRace, int stNum)
    {
        DatabaseConnector dc = new DatabaseConnector(TimerActivity.this);
        Cursor c = dc.getResultCount(idRace, stNum);
        boolean resultExist = false;
        if(c.moveToFirst())
        {
            resultExist = c.getInt(c.getColumnIndex("count")) >= 1 ? true : false; 
        }
        dc.close();
        return resultExist;
    }
}