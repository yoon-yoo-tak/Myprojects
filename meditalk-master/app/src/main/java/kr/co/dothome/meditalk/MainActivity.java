package kr.co.dothome.meditalk;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ShapeDrawable;
import android.graphics.drawable.shapes.OvalShape;
import android.os.Bundle;
import android.text.Html;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.drawerlayout.widget.DrawerLayout;

import com.google.gson.JsonObject;

import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;

import kr.co.dothome.meditalk.Mypage.MemberWithdrawal;
import kr.co.dothome.meditalk.Mypage.ModifyPassword;
import kr.co.dothome.meditalk.Mypage.ModifyUser;
import kr.co.dothome.meditalk.onlineBooking.OnlineBooking;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {
    TextView noticeText;
    TextView userName;

    ImageView mypageBtn;
    DrawerLayout drawerLayout;
    ImageView profile;
    ListView listView;
    ArrayList<String> al;
    ImageView closeDraw;
    private DataRepository dataRepository;
    private TextView mypage_name;
    private TextView onePlace;
    private TextView tenPlace;
    private TextView hunPlace;
    private LinearLayout day_container;
    private long lastTimeBackPressed;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        drawerLayout = findViewById(R.id.drawer_layout);
        mypageBtn = findViewById(R.id.mypage_btn);
        closeDraw = findViewById(R.id.close_draw);
        noticeText = findViewById(R.id.notice_text);
        userName   = findViewById(R.id.user_name);
        dataRepository = new DataRepository(getApplicationContext());
        mypage_name = findViewById(R.id.mypage_name);
        onePlace = findViewById(R.id.onePlace);
        tenPlace = findViewById(R.id.tenPlace);
        hunPlace = findViewById(R.id.hunPlace);
        day_container = findViewById(R.id.day_container);
        mypage_name.setText(dataRepository.getUserName()+"님 반갑습니다");

        String user_id = dataRepository.getUserId();
        HashMap<String,String> hashMap = new HashMap<>();
        hashMap.put("user_id",user_id);
        Call<JsonObject> call = RequestHttp.getInstance().bookingInfo(hashMap);
        call.enqueue(new Callback<JsonObject>() {
            @Override
            public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                try {

                    JSONObject obj = new JSONObject(response.body().toString());

                    if(obj.getBoolean("empty") == false) {
                        int day = getDateDistance(obj.getString("bf_date"));
                        textDesign(obj.getString("hp_name"), day);

                    }else{
                        day_container.setVisibility(View.GONE);
                        String start = "<font color=\"#34446E\"><b>즐거운 하루</b></font>";
                        String end   = " 되세요!";
                        noticeText.setText(Html.fromHtml(start + end));
                    }
                    String name = "<font color=\"#34446E\">"+dataRepository.getUserName()+"님</font>";
                    userName.setText(Html.fromHtml(name));
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onFailure(Call<JsonObject> call, Throwable t) {

            }
        });
        //키해시
        //앱 고유값으로 sha 암호화
       /* try {
            PackageInfo info = getPackageManager().getPackageInfo(
                    getPackageName(), PackageManager.GET_SIGNATURES);
            for (Signature signature : info.signatures) {
                MessageDigest md = MessageDigest.getInstance("SHA");
                md.update(signature.toByteArray());
                Log.e("error",
                        Base64.encodeToString(md.digest(), Base64.DEFAULT));
            }
        } catch (PackageManager.NameNotFoundException e) {

        } catch (NoSuchAlgorithmException e) {

        }*/
        mypageBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                drawerLayout.openDrawer(Gravity.RIGHT);
            }
        });
        closeDraw.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                drawerLayout.closeDrawer(Gravity.RIGHT);
            }
        });
        listView= findViewById(R.id.listView);
        profile = findViewById(R.id.profile);
        profile.setBackground(new ShapeDrawable(new OvalShape()));
        profile.setClipToOutline(true);

        al = new ArrayList<>();
        al.add("회원정보 수정");
        al.add("비밀번호 변경");
        al.add("회원탈퇴");
        al.add("로그아웃");
        MyAdapter myAdapter = new MyAdapter();
        listView.setAdapter(myAdapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

                switch (i){
                    case 0:
                        Intent intent = new Intent(getApplicationContext(), ModifyUser.class);
                        startActivity(intent);
                        break;
                    case 1:
                        Intent intent1 = new Intent(getApplicationContext(), ModifyPassword.class);
                        startActivity(intent1);
                        break;
                    case 2:
                        Intent intent2 = new Intent(getApplicationContext(), MemberWithdrawal.class);
                        startActivity(intent2);
                        break;
                    case 3:
                        dataRepository.logout();
                        Intent intent3 = new Intent(getApplicationContext(),LoginActivity.class);
                        startActivity(intent3);
                        startActivity(intent3);
                        finish();
                        break;

                }
            }
        });
    }

    public int getDateDistance(String date) throws ParseException {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String currentDate= sdf.format(new Date());
        Date start_date = sdf.parse(date);
        Date end_date = sdf.parse(currentDate);

        long diff = (start_date.getTime()-end_date.getTime())/(24*60*60*1000);
        return (int) Math.abs(diff);
    }
    class MyAdapter extends BaseAdapter {


        @Override
        public int getCount() { // ListView 에서 사용할 데이터의 총개수
            return al.size();
        }
        @Override
        public Object getItem(int position) { // 해당 position번째의 데이터 값
            return al.get(position);
        }
        @Override
        public long getItemId(int position){// 해당 position번째의 유니크한id 값
            return position;
        }
        @SuppressLint("ResourceType")
        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            Context context = getApplicationContext();
            if (convertView == null) {
                LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                convertView = inflater.inflate(R.layout.list_row, parent, false);

            }
            ViewGroup.LayoutParams layoutParams = convertView.getLayoutParams();
            layoutParams.height=150;
            convertView.setLayoutParams(layoutParams);
            TextView textView = convertView.findViewById(R.id.item_text);
            textView.setText(al.get(position));
            textView.setTextColor(Color.BLACK);
            return convertView;
        }
    }
    private void textDesign(String hp_name,int day){



        if(day<10){
            onePlace.setText(day+"");
        }else if(day<100){
            onePlace.setText((day % 10)+"");
            tenPlace.setText((Math.abs(day/10))+"");
        }else{
            onePlace.setText((day % 10)+"");
            tenPlace.setText((Math.abs(day/10)%10)+"");
            hunPlace.setText((Math.abs(day/10/10))+"");
        }

        String txtStart;
        if(day == 0){
            txtStart="오늘";
        }else{
            txtStart=day+"일후 ";
        }
        String txtCenter = "<font color=\"#34446E\"><b>"+hp_name+" 진료예정</b></font>";
        String txtEnd = "입니다";
        noticeText.setText(Html.fromHtml(txtStart + txtCenter + txtEnd));


    }
    @Override
    public void onBackPressed()
    {

        if (System.currentTimeMillis() - lastTimeBackPressed < 2000)
        {
            finish();

        }
        else
        {

            lastTimeBackPressed = System.currentTimeMillis();
            Toast.makeText(getApplicationContext(),"\'뒤로\' 한번 더 클릭하면 앱종료됩니다",Toast.LENGTH_LONG).show();
        }

    }

    //온라인 예약 버튼 클릭시
    public void onlineBookingClicked(View v){
        Intent intent = new Intent(this, OnlineBooking.class);
        intent.putExtra("keyword","book");
        startActivity(intent);

        finish();
    }
    // 약알리미 버튼 클릭시
    public void alarm(View v){
        Intent intent = new Intent(getApplicationContext(), Alarm.class);
        startActivity(intent);
    }
    // 내역조회 버틑 클릭시
    public void medicalStatusClicked(View v){
        Intent intent = new Intent(getApplicationContext(),MedicalStatus.class);
        startActivity(intent);
        finish();
    }
    //의료정보 버튼 클릭시
    public void medicalInfoClicked(View v){
        Intent intent = new Intent(getApplicationContext(),MedicalInfo.class);
        startActivity(intent);
        finish();

    }


}
