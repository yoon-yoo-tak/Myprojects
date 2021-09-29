package kr.co.dothome.meditalk;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TabHost;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentTabHost;

import kr.co.dothome.meditalk.FragmentStatus.BookingHistory;
import kr.co.dothome.meditalk.FragmentStatus.BookingStatus;
import kr.co.dothome.meditalk.FragmentStatus.ShareMedicalInfo;

public class MedicalStatus extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_medical_status);
        FragmentTabHost tabHost = (FragmentTabHost) findViewById(R.id.tabHost);
        tabHost.setup(this,getSupportFragmentManager(), R.id.content);

        TabHost.TabSpec tab1 = tabHost.newTabSpec("bs");
        tab1.setIndicator("예약현황");
        tabHost.addTab(tab1, BookingStatus.class,null);

        TabHost.TabSpec tab2 = tabHost.newTabSpec("bh");
        tab2.setIndicator("예약내역");
        tabHost.addTab(tab2, BookingHistory.class,null);

        TabHost.TabSpec tab3 = tabHost.newTabSpec("smi");
        tab3.setIndicator("의료정보공유");
        tabHost.addTab(tab3, ShareMedicalInfo.class,null);



        }
    public void backClicked(View v){
        Intent intent = new Intent(getApplicationContext(),MainActivity.class);
        startActivity(intent);
        finish();
    }
    //뒤로가기 버튼 클릭
    @Override
    public void onBackPressed(){
        Intent intent = new Intent(getApplicationContext(),MainActivity.class);
        startActivity(intent);
        finish();
    }
}
