package fast.campus.meditalklogin.Mypage;


import android.os.Bundle;
import android.util.Log;
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

import fast.campus.meditalklogin.R;
import fast.campus.meditalklogin.repository.DataRepository;
import fast.campus.meditalklogin.request.RequestHttp;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ModifyPassword extends AppCompatActivity {
    private ImageView back;
    private EditText c_pw;
    private EditText n_pw;
    private EditText n_pw_c;
    private DataRepository dataRepository;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_modify_password);

        back = findViewById(R.id.back);
        //현재 비밀번호
        c_pw = findViewById(R.id.c_pw);
        //새 비밀번호
        n_pw = findViewById(R.id.n_pw);
        //비밀번호 확인
        n_pw_c = findViewById(R.id.n_pw_c);

        dataRepository = new DataRepository(getApplicationContext());

    }
    public void modifyPw(View v){
        if((n_pw.getText().toString().equals(n_pw_c.getText().toString())) &&
                (!n_pw.getText().toString().equals("")) &&
                (!c_pw.getText().toString().equals("")))
        {
            Toast.makeText(getApplicationContext(),c_pw.getText().toString(),Toast.LENGTH_LONG).show();
            //Toast.makeText(getApplicationContext(),"id:"+dataRepository.getUserId(),Toast.LENGTH_LONG).show();
            HashMap<String,String> hashMap = new HashMap<>();
            hashMap.put("user_id",dataRepository.getUserId());
            hashMap.put("c_pw",c_pw.getText().toString());
            hashMap.put("n_pw",n_pw.getText().toString());
            Call<JsonObject> call = RequestHttp.getInstance().modifyPassword(hashMap);
            call.enqueue(new Callback<JsonObject>() {
                @Override
                public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                    try {

                        JSONObject obj = new JSONObject(response.body().toString());
                        if(obj.getBoolean("success")){
                            Toast.makeText(getApplicationContext(),"변경 성공",Toast.LENGTH_LONG).show();
                            finish();
                        }else{
                            Toast.makeText(getApplicationContext(),"현재 비밀번호가 일치하지 않습니다.",Toast.LENGTH_LONG).show();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }

                @Override
                public void onFailure(Call<JsonObject> call, Throwable t) {
                    Log.d("error",t+"");
                }
            });


        }else{
            Toast.makeText(this,"비밀번호가 일치하지 않습니다.",Toast.LENGTH_LONG).show();
        }
    }
}
