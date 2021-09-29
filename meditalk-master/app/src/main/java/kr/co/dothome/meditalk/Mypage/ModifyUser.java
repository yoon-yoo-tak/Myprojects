package kr.co.dothome.meditalk.Mypage;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.JsonObject;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import kr.co.dothome.meditalk.R;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ModifyUser extends AppCompatActivity {
    private EditText email;

    private DataRepository dataRepository;
    private ImageView back;
    private Button btnModify;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_modify_user);
        dataRepository = new DataRepository(getApplicationContext());
        email = findViewById(R.id.email);

        back  = findViewById(R.id.back);
        btnModify = findViewById(R.id.btn_modify);



        email.setText(dataRepository.getUserEmail());
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
