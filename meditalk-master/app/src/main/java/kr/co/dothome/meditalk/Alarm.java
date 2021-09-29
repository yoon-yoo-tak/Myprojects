package kr.co.dothome.meditalk;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.CheckBox;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.drawerlayout.widget.DrawerLayout;

import com.google.gson.JsonObject;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Locale;

import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Alarm extends AppCompatActivity {
    ImageView imageView;
    TextView alarm1, alarm2, alarm3,settingAlarm;
    CheckBox checkBox1,checkBox2,checkBox3;
    DrawerLayout drawerLayout;
    TimePicker picker;
    TextView saveBtn;
    int alarmNum;
    boolean alarmStatus;
    DataRepository dataRepository;
    JSONObject json;
    TextView medicine_count;
    int dayCount;
    ImageView closeDraw;
    TextView userName;
    LinearLayout header_text;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_alarm);
        dataRepository = new DataRepository(getApplicationContext());

        header_text=findViewById(R.id.header_text);
        imageView = findViewById(R.id.BacktoMain);
        closeDraw = findViewById(R.id.close_draw);
        userName  = findViewById(R.id.user_name);
        medicine_count = findViewById(R.id.medicine_count);
        alarm1 = (TextView) findViewById(R.id.alarm1);
        alarm2 = (TextView) findViewById(R.id.alarm2);
        alarm3 = (TextView) findViewById(R.id.alarm3);
        checkBox1 = (CheckBox) findViewById(R.id.checkbox1);
        checkBox2 = (CheckBox) findViewById(R.id.checkbox2);
        checkBox3 = (CheckBox) findViewById(R.id.checkbox3);

        drawerLayout = findViewById(R.id.drawer_layout);
        picker       = findViewById(R.id.timePicker);
        picker.setIs24HourView(true);
        saveBtn      = findViewById(R.id.save_btn);


        request();



        imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        long time;
        SharedPreferences sharedPreferences = getSharedPreferences("daily alarm", MODE_PRIVATE);

        if((time=sharedPreferences.getLong("alarm1",-1))!= -1)
            alarm1.setText(milisToStringTime(time));

        if((time=sharedPreferences.getLong("alarm2",-1)) != -1)
            alarm2.setText(milisToStringTime(time));

        if((time=sharedPreferences.getLong("alarm3",-1)) != -1)
            alarm3.setText(milisToStringTime(time));


        checkBox1.setChecked(sharedPreferences.getBoolean("status1",false));
        checkBox2.setChecked(sharedPreferences.getBoolean("status2",false));
        checkBox3.setChecked(sharedPreferences.getBoolean("status3",false));
        alarm1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                drawerLayout.openDrawer(Gravity.RIGHT);
                settingAlarm=alarm1;
                alarmNum=1;
            }
        });

        alarm2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                drawerLayout.openDrawer(Gravity.RIGHT);
                settingAlarm=alarm2;
                alarmNum=2;
            }
        });

        alarm3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                drawerLayout.openDrawer(Gravity.RIGHT);
                settingAlarm=alarm3;
                alarmNum=3;
            }
        });

        checkBox1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if(checkBox1.isChecked()){
                    settingAlarm=alarm1;
                    alarmNum=1;
                    stringToTime();

                    statusChange(1,true);
                }else {
                    statusChange(1,false);
                    cancelAlarm(1);
                }

            }
        });
        checkBox2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(checkBox2.isChecked()){
                    settingAlarm=alarm2;
                    alarmNum=2;
                    stringToTime();
                    statusChange(2,true);
                }else {
                    statusChange(2,false);
                    cancelAlarm(2);
                }
            }
        });
        checkBox3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(checkBox3.isChecked()){
                    settingAlarm=alarm3;
                    alarmNum=3;
                    stringToTime();
                    statusChange(3,true);
                }else {
                    statusChange(3,false);
                    cancelAlarm(3);
                }
            }
        });

        //알람 세팅후 저장버튼 클릭시
        saveBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                drawerLayout.closeDrawer(Gravity.RIGHT);

                int hour, hour_24, minute;
                String am_pm;
                if (Build.VERSION.SDK_INT >= 23 ){
                    hour_24 = picker.getHour();
                    minute = picker.getMinute();
                }
                else{
                    hour_24 = picker.getCurrentHour();
                    minute = picker.getCurrentMinute();
                }


                // 현재 지정된 시간으로 알람 시간 설정
                Calendar calendar = Calendar.getInstance();
                calendar.setTimeInMillis(System.currentTimeMillis());
                calendar.set(Calendar.HOUR_OF_DAY, hour_24);
                calendar.set(Calendar.MINUTE, minute);
                calendar.set(Calendar.SECOND, 0);

                // 이미 지난 시간을 지정했다면 다음날 같은 시간으로 설정
                if (calendar.before(Calendar.getInstance())) {
                    calendar.add(Calendar.DATE, 1);
                }
                Date currentDateTime = calendar.getTime();
                String date_text = new SimpleDateFormat("a hh:mm", Locale.getDefault()).format(currentDateTime);
                settingAlarm.setText(date_text);
                Toast.makeText(getApplicationContext(),date_text+"으로 알람설정 되었습니다.",Toast.LENGTH_LONG).show();
                //  Preference에 설정한 값 저장
                SharedPreferences.Editor editor = getSharedPreferences("daily alarm", MODE_PRIVATE).edit();
                editor.putLong("alarm"+alarmNum, (long)calendar.getTimeInMillis());
                editor.apply();
                diaryNotification(calendar);
            }
        });
        closeDraw.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                drawerLayout.closeDrawer(Gravity.RIGHT);
            }
        });
    }
    void statusChange(int num, boolean status){
        if(status){
            Toast.makeText(getApplicationContext(),"알람이 설정되었습니다.",Toast.LENGTH_LONG).show();

        }else {
            Toast.makeText(getApplicationContext(),"알람이 해제되었습니다.",Toast.LENGTH_LONG).show();
        }
        SharedPreferences.Editor editor = getSharedPreferences("daily alarm", MODE_PRIVATE).edit();
        editor.putBoolean("status"+num,status);
        editor.apply();
}

    public void request(){

        HashMap<String,String> hashMap = new HashMap<>();
        hashMap.put("user_id",dataRepository.getUserId());
        Call<JsonObject> call = RequestHttp.getInstance().medicineCount(hashMap);
        call.enqueue(new Callback<JsonObject>() {
            @Override
            public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {

                try {
                    json = new JSONObject(response.body().toString());
                    if(json.getBoolean("success")) {
                        Toast.makeText(getApplicationContext(),"hello",Toast.LENGTH_LONG).show();
                        dayCount = Math.round(Float.parseFloat(json.getString("count")));

                        if(dayCount == 1){
                            alarm1.setText("AM 9:30");
                        }
                        else if (dayCount == 2) {
                            alarm1.setText("AM 9:30");
                            alarm2.setText("PM 6:30");
                        } else if (dayCount == 3) {
                            alarm1.setText("AM 9:30");
                            alarm2.setText("PM 12:30");
                            alarm3.setText("PM 6:30");
                        }
                        userName.setText(dataRepository.getUserName() + "님");
                        medicine_count.setText("1일 " + dayCount + "회");
                    }else{

                        header_text.setVisibility(View.GONE);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onFailure(Call<JsonObject> call, Throwable t) {
                Toast.makeText(getApplicationContext(),call+"",Toast.LENGTH_LONG).show();
            }
        });
    }
void cancelAlarm(int alarmId){
        AlarmManager manager = (AlarmManager) getApplicationContext().getSystemService(getApplicationContext().ALARM_SERVICE);
        Intent intent = new Intent(this,AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(this,alarmId,intent,0);
        manager.cancel(pendingIntent);

}

    void diaryNotification(Calendar calendar)
    {

        Boolean dailyNotify = true; // 무조건 알람을 사용

        PackageManager pm = this.getPackageManager();
        ComponentName receiver = new ComponentName(this, DeviceBootReceiver.class);
        Intent alarmIntent = new Intent(this, AlarmReceiver.class);

        PendingIntent pendingIntent = PendingIntent.getBroadcast(this,alarmNum, alarmIntent, 0);
        AlarmManager alarmManager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);


        // 사용자가 매일 알람을 허용했다면
        if (dailyNotify) {


            if (alarmManager != null) {

                alarmManager.setRepeating(AlarmManager.RTC_WAKEUP, calendar.getTimeInMillis(),
                        AlarmManager.INTERVAL_DAY, pendingIntent);

                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                    alarmManager.setExactAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, calendar.getTimeInMillis(), pendingIntent);
                }
            }

            // 부팅 후 실행되는 리시버 사용가능하게 설정
            pm.setComponentEnabledSetting(receiver,
                    PackageManager.COMPONENT_ENABLED_STATE_ENABLED,
                    PackageManager.DONT_KILL_APP);

        }

    }
    String milisToStringTime(long time){
        Calendar milisToTime = Calendar.getInstance();

        milisToTime.setTimeInMillis(time);
        return  new SimpleDateFormat("a hh:mm", Locale.getDefault()).format(milisToTime.getTime());

    }
    void stringToTime()  {
        try {
            Calendar calendar = Calendar.getInstance();
            calendar.setTimeInMillis(System.currentTimeMillis());
            String time = (String) settingAlarm.getText();
            int index;
            if((index=time.indexOf(":"))!=-1){
                int hour = Integer.parseInt(time.substring(index-2,index));
                int minute = Integer.parseInt(time.substring(index+1));
                String am_pm = time.substring(0,2);

                if(am_pm.equals("PM") || am_pm.equals("오후") || am_pm.equals("pm")){
                    hour+=12;
                }
                Toast.makeText(getApplicationContext(),hour+"",Toast.LENGTH_LONG).show();
                calendar.set(Calendar.HOUR_OF_DAY, hour);
                calendar.set(Calendar.MINUTE, minute);
                calendar.set(Calendar.SECOND, 0);
                diaryNotification(calendar);
            }


        }catch (Exception e){
            e.printStackTrace();
        }
    }
}

