package fast.campus.meditalklogin.Mypage;


import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
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

public class MemberWithdrawal extends AppCompatActivity {
    private EditText pw;
    private DataRepository dataRepository;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_member_withdrawal);
        dataRepository = new DataRepository(getApplicationContext());
        pw = findViewById(R.id.pw);

    }
    public void memberWithdrawal(View v){
        HashMap<String,String> hashMap = new HashMap<>();
        hashMap.put("id",dataRepository.getUserId());
        hashMap.put("pw",pw.getText().toString());
        Call<JsonObject> call = RequestHttp.getInstance().modifyPassword(hashMap);
        call.enqueue(new Callback<JsonObject>() {
            @Override
            public void onResponse(Call<JsonObject> call, Response<JsonObject> response) {
                try {
                    JSONObject obj = new JSONObject(response.body().toString());
                    if(obj.getBoolean("success")){
                        Toast.makeText(getApplicationContext(),"회원탈퇴 성공",Toast.LENGTH_LONG).show();
                    }else{
                       Toast.makeText(getApplicationContext(),"회원탈퇴 실패",Toast.LENGTH_LONG).show();
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
}
