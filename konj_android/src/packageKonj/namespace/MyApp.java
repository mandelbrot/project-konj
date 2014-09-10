package packageKonj.namespace;
import android.app.Application;

public class MyApp extends Application {
	int IDRACE;
  public int getIdRace()
  {
	     return this.IDRACE;
  }
  public void setIdRace(int d)
  {
	     this.IDRACE=d;
  }
}