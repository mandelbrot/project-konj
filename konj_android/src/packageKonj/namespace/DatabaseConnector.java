package packageKonj.namespace;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.database.sqlite.SQLiteDatabase.CursorFactory;

public class DatabaseConnector 
{
   private static final String DATABASE_NAME = "konj";
   private SQLiteDatabase database; 
   private DatabaseOpenHelper databaseOpenHelper; 

   public DatabaseConnector(Context context) 
   {
      databaseOpenHelper = new DatabaseOpenHelper(context, DATABASE_NAME, null, 1);
   } 

   public void open() throws SQLException 
   {
      database = databaseOpenHelper.getWritableDatabase();
   } 

   public void close() 
   {
      if (database != null)
         database.close(); 
   }

   public void insertClub(int id, String clu_nam, String clu_transfer) 
   {
      ContentValues newClub = new ContentValues();
      newClub.put("id", id);
      newClub.put("clu_nam", clu_nam);
      newClub.put("clu_transfer", clu_transfer);

      open(); 
      database.insert("club", null, newClub);
      close();
   } 

   public void updateClub(int id, String clu_nam, String clu_transfer) 
   {
      ContentValues editClub = new ContentValues();
      editClub.put("id", id);
      editClub.put("clu_nam", clu_nam);
      editClub.put("clu_transfer", clu_transfer);

      open(); 
      database.update("club", editClub, "id=" + id, null);
      close(); 
   } 
   
   public Cursor getValue(String tablica, String kolona, int id) 
   {
      open(); 
      return database.query(tablica, new String[] {kolona}, "id=" + id, null, null, null, null);
   } 
   
   public Cursor getAllClubs() 
   {
      return database.query("clubs", new String[] {"id", "clu_nam"}, null, null, null, null, "clu_nam");
   } 

   public Cursor getOneClub(int id) 
   {
      return database.query("clubs", new String[] {"id", "clu_nam"}, "id=" + id, null, null, null, null);
   } 

   public Cursor getRaceChrono(int id) 
   {
      open(); 
      return database.query("race", new String[] {"id", "rac_chrono"}, "id=" + id, null, null, null, null);
   } 

   public Cursor getResultCount(int idRace, int stNum) 
   {
      open(); 
      return database.query("race_result", new String[] {"count(*) as count"}, "rac_id=" + idRace + " and st_num=" + stNum, null, null, null, null);
   } 
   
   public void deleteClub(int id) 
   {
      open(); 
      database.delete("club", "id=" + id, null);
      close(); 
   }

   public void insertParticipant(int id, String per_nam, String per_sur, String per_shi, String per_yea, String per_sex, 
		   String per_email, String per_mob, String per_clu, String per_transfer) 
   {
      ContentValues newClub = new ContentValues();
      newClub.put("id", id);
      newClub.put("per_nam", per_nam);
      newClub.put("per_sur", per_sur);
      newClub.put("per_shi", per_shi);
      newClub.put("per_yea", per_yea);
      newClub.put("per_sex", per_sex);
      newClub.put("per_email", per_email);
      newClub.put("per_mob", per_mob);
      newClub.put("per_clu", per_clu);
      newClub.put("per_transfer", per_transfer);

      open(); 
      database.insert("participant", null, newClub);
      close();
   } 

   public void insertRace(int id, String rac_nam, String rac_chrono) 
   {
      ContentValues newClub = new ContentValues();
      newClub.put("id", id);
      newClub.put("rac_nam", rac_nam);
      newClub.put("rac_chrono", rac_chrono);

      open(); 
      database.insert("race", null, newClub);
      close();
   } 

   public void insertRegistration(int rac_id, String per_id, String st_num, String st_transfer) 
   {
      ContentValues newClub = new ContentValues();
      newClub.put("rac_id", rac_id);
      newClub.put("per_id", per_id);
      newClub.put("st_num", st_num);
      newClub.put("st_transfer", st_transfer);

      open(); 
      database.insert("race_reg", null, newClub);
      close();
   } 

   public void insertResult(int rac_id, int st_num, String res_time, long res_sec, String res_typ, String res_dt, String res_start) 
   {
      ContentValues newClub = new ContentValues();
      newClub.put("rac_id", rac_id);
      newClub.put("st_num", st_num);
      newClub.put("res_time", res_time);
      newClub.put("res_sec", res_sec);
      newClub.put("res_typ", res_typ);
      newClub.put("res_dt", res_dt);
      newClub.put("res_start", res_start);

      open(); 
      database.insert("race_result", null, newClub);
      close();
   } 
   
   private class DatabaseOpenHelper extends SQLiteOpenHelper 
   {
      public DatabaseOpenHelper(Context context, String name,
         CursorFactory factory, int version) 
      {
         super(context, name, factory, version);
      } 

      @Override
      public void onCreate(SQLiteDatabase db) 
      {
         // query to create a new table named contacts
         /*String createQuery = "CREATE TABLE club" +
            "(id integer primary key autoincrement," +
            "clu_nam TEXT," +
            "clu_transfer TEXT);";
                  
         db.execSQL(createQuery); // execute the query*/
      }

      @Override
      public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) 
      {
      } 
   } 
} 


/**************************************************************************
 * (C) Copyright 1992-2012 by Deitel & Associates, Inc. and               *
 * Pearson Education, Inc. All Rights Reserved.                           *
 *                                                                        *
 * DISCLAIMER: The authors and publisher of this book have used their     *
 * best efforts in preparing the book. These efforts include the          *
 * development, research, and testing of the theories and programs        *
 * to determine their effectiveness. The authors and publisher make       *
 * no warranty of any kind, expressed or implied, with regard to these    *
 * programs or to the documentation contained in these books. The authors *
 * and publisher shall not be liable in any event for incidental or       *
 * consequential damages in connection with, or arising out of, the       *
 * furnishing, performance, or use of these programs.                     *
 **************************************************************************/
