package kr.co.dothome.meditalk.onlineBooking;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.webkit.JavascriptInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

import kr.co.dothome.meditalk.MainActivity;
import kr.co.dothome.meditalk.R;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;

public class OnlineBooking extends AppCompatActivity {
    private WebView webView;
    private double lat=36.6521308;
    private double lng=127.4945351;
    private LocationManager lm;
    private DataRepository dataRepository;




    @SuppressLint("JavascriptInterface")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_online_booking);

        Intent intent = getIntent();
        String keyword = intent.getStringExtra("keyword");


        //initLocation();
        dataRepository = new DataRepository(getApplicationContext());
        webView = findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.addJavascriptInterface(new AndroidBridge(), "android");
        //재예약
        if (keyword.equals("rebook")) {
            String url = RequestHttp.getUrl() + "mobile/online_booking/online_booking_d1.php";
            String hp_id = intent.getStringExtra("hp_id");
            try {
                String postData = "hp_pk=" + URLEncoder.encode(hp_id, "UTF-8");
                webView.postUrl(url, postData.getBytes());

            } catch (UnsupportedEncodingException e) {
                e.printStackTrace();
            }


        } else {
            String url = RequestHttp.getUrl() + "mobile/online_booking/online_booking_d1.php";
            webView.loadUrl(url);
        }
        webView.setWebChromeClient(new WebChromeClient());
        webView.setWebViewClient(new WebViewClient());
    }
    //js 통신
    public class AndroidBridge {
        @JavascriptInterface
        public double getLat() {

            return lat;
        }
        @JavascriptInterface
        public double getLng(){

            return lng;
        }
        @JavascriptInterface
        public void back(){
           finishActivity();
        }


        @JavascriptInterface
        public String getUserId(){
            return dataRepository.getUserId();
        }
        @JavascriptInterface
        public int distance(String slat2,String slng2){
            double lat2 = Double.parseDouble(slat2);
            double lng2 = Double.parseDouble(slng2);
            Location l1 = new Location("user");
            l1.setLatitude(lat);
            l1.setLongitude(lng);
            Location l2 = new Location("hospital");
            l2.setLatitude(lat2);
            l2.setLongitude(lng2);

            double distance = l1.distanceTo(l2);

            return (int)distance;
        }
        @JavascriptInterface
        public void callPhone(String tel){
            Intent intent = new Intent(Intent.ACTION_DIAL, Uri.parse("tel:"+tel));
            startActivity(intent);


        }
    }

    private void initLocation() {

        lm = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        if (Build.VERSION.SDK_INT >= 23 &&
                ContextCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{android.Manifest.permission.ACCESS_FINE_LOCATION},
                    0);

        } else {
            Location location = lm.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
            if(location == null){
                location=lm.getLastKnownLocation(LocationManager.GPS_PROVIDER);
            }

            lng = location.getLongitude();
            lat = location.getLatitude();
            Log.d("debug","lat:"+lat+", lng:"+lng);
            Toast.makeText(getApplicationContext(),"lat:"+lat+", lng:"+lng,Toast.LENGTH_LONG).show();

            lm.requestLocationUpdates(LocationManager.GPS_PROVIDER,
                    1000,
                    1,
                    gpsLocationListener);
            lm.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,
                    1000,
                    1,
                    gpsLocationListener);
        }
    }
    //뒤로가기 버튼 클릭시
    @Override
    public void onBackPressed(){
        finishActivity();
    }
    public void finishActivity(){
        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
        startActivity(intent);
        finish();
    }
    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {

        if (grantResults.length > 0
                && grantResults[0] == PackageManager.PERMISSION_GRANTED) {

            Toast.makeText(this,"승인이 허가되어 있습니다.",Toast.LENGTH_LONG).show();

        }
        else {
            Toast.makeText(this,"아직 승인받지 않았습니다.",Toast.LENGTH_LONG).show();
        }


    }


    final LocationListener gpsLocationListener = new LocationListener() {
        public void onLocationChanged(Location location) {
            if(location != null) {
                lng = location.getLongitude();
                lat = location.getLatitude();
                //Toast.makeText(getApplicationContext(),"lng:"+lng+",lat:"+lat, Toast.LENGTH_LONG).show();
            }
        }

        public void onStatusChanged(String provider, int status, Bundle extras) {
        }

        public void onProviderEnabled(String provider) {
        }

        public void onProviderDisabled(String provider) {
        }
    };
    private class  WebViewClient extends android.webkit.WebViewClient{
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            view.loadUrl(url);
            return true;
        }
    }
}
