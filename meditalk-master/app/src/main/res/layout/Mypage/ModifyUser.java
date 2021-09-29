package fast.campus.meditalklogin.Mypage;


import android.annotation.SuppressLint;
import android.icu.text.LocaleDisplayNames;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.JavascriptInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.JsonObject;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import fast.campus.meditalklogin.MeditalkRegister;
import fast.campus.meditalklogin.R;
import fast.campus.meditalklogin.onlineBooking.OnlineBooking;
import fast.campus.meditalklogin.repository.DataRepository;
import fast.campus.meditalklogin.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ModifyUser extends AppCompatActivity {
    private EditText email;
    private EditText phone;
    private EditText addr;
    private DataRepository dataRepository;
    private ImageView back;
    private Button btnModify;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_modify_user);

        dataRepository = new DataRepository(getApplicationContext());
        email = findViewById(R.id.email);
        phone = findViewById(R.id.phone);
        addr  = findViewById(R.id.addr);
        back  = findViewById(R.id.back);
        btnModify = findViewById(R.id.btn_modify);

        email.setText(dataRepository.getUserEmail());
        phone.setText(dataRepository.getUserPhone());
        addr.setText(dataRepository.getUserAddr());

        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                 finish();
            }
        });

        btnModify.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                HashMap<String,String> hashMap = new HashMap<>();
                hashMap.put("user_id",dataRepository.getUserId());
                hashMap.put("user_email",email.getText().toString());
                hashMap.put("user_phone",phone.getText().toString());
                hashMap.put("user_addr",addr.getText().toString());
                Call<JsonObject> call = RequestHttp.getInstance().modifyUser(hashMap);
                call.enqueue(new Callback<JsonObject>() {
                    @Override
                    public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                        try {
                            JSONObject obj = new JSONObject(response.body().toString());
                            if(obj.getBoolean("success")){

                                Toast.makeText(getApplicationContext(),"회원정보 수정 성공",Toast.LENGTH_SHORT).show();
                                //변경된 이메일 저장
                                dataRepository.setUserEmail(obj.getString("user_email"));
                                //변경된 전화번호 저장
                                dataRepository.setUserPhone(obj.getString("user_phone"));
                                //변경된 주소 저장
                                dataRepository.setUserAddr(obj.getString("user_addr"));
                                finish();

                            }else{
                                Toast.makeText(getApplicationContext(),"회원정보 수정 실패",Toast.LENGTH_SHORT).show();
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }

                    @Override
                    public void onFailure(Call<JsonObject> call, Throwable t) {

                    }
                });
            }
        });


    }

}
