package kr.co.dothome.meditalk;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.JsonObject;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {
    private EditText et_id, et_pass;
    private Button btn_login;
    private TextView btn_register;
    private DataRepository dataRepository;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        et_id = findViewById(R.id.et_id);
        et_pass = findViewById(R.id.et_pass);
        btn_login = findViewById(R.id.btn_login);
        btn_register = findViewById(R.id.btn_register);
        dataRepository = new DataRepository(getApplicationContext());

        if(dataRepository.getUserId() != ""){
            Intent intent = new Intent(getApplicationContext(),MainActivity.class);

            startActivity(intent);
            finish();
        }

        //회원가입 버튼을 클릭 시 수행
        btn_register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(LoginActivity.this, MeditalkRegister.class);
                startActivity(intent);
            }
        });

        btn_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //EditText에 현재 입력되어있는 값을 가져온다.
                final String user_id = et_id.getText().toString();
                String user_pw = et_pass.getText().toString();

                HashMap<String,String> map = new HashMap<>();

                map.put("user_id",user_id);//retrofit2
                map.put("user_pw",user_pw);

                Call<JsonObject> call = RequestHttp.getInstance().login(map);
                call.enqueue(new Callback<JsonObject>() {
                    @Override
                    public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                        try {
                            JSONObject obj = new JSONObject(response.body().toString());
                            if(obj.getBoolean("success")){
                                Toast.makeText(getApplicationContext(),"로그인 성공",Toast.LENGTH_LONG).show();
                                //아이디 저장
                                dataRepository.setUserId(user_id);
                                //이름 저장
                                dataRepository.setUserName(obj.getString("user_name"));
                                //이메일 저장
                                dataRepository.setUserEmail(obj.getString("user_email"));


                                Intent intent = new Intent(getApplicationContext(),MainActivity.class);
                                startActivity(intent);
                                finish();
                            }else{
                                Toast.makeText(getApplicationContext(),"로그인 실패",Toast.LENGTH_LONG).show();

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
    //비밀번호 찾기 버튼
    public void findPwClicked(View v){
        Intent intent = new Intent(getApplicationContext(),FindPassword.class);
        startActivity(intent);
    }
    }

