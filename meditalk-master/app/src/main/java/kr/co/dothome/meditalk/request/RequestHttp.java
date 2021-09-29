package kr.co.dothome.meditalk.request;


import com.google.gson.JsonObject;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class RequestHttp {
    private static final String HOST = "http://meditalk.dothome.co.kr/";
    private static RequestHttp requestHttp=null;
    Retrofit retrofit;
    RetrofitApi retrofitApi;

    private RequestHttp() {

        retrofit = new Retrofit.Builder()
                .baseUrl(HOST)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
        retrofitApi = retrofit.create(RetrofitApi.class);
    }
    public static String getUrl(){
        return HOST;
    }
    public static RequestHttp getInstance(){
        if (requestHttp == null) {
            requestHttp = new RequestHttp();
        }
        return requestHttp;
    }
    //로그인
    public Call<JsonObject> login(HashMap<String, String> hashMap) {
        return retrofitApi.login(hashMap);
    }
    //회원정보 수정
    public Call<JsonObject> modifyUser(HashMap<String,String> hashMap){
        return retrofitApi.modifyUser(hashMap);
    }
    //비밀번호 수정
    public Call<JsonObject> modifyPassword(HashMap<String,String> hashMap){
        return retrofitApi.modifyPassword(hashMap);
    }
    //회원탈퇴
    public Call<JsonObject> memberWithdrawal(HashMap<String,String> hashMap){
        return retrofitApi.memberWithdrawal(hashMap);
    }
    //예약 정보 가져오기
    public Call<JsonObject> bookingInfo(HashMap<String,String> hashMap){
        return retrofitApi.bookingInfo(hashMap);
    }
    //약 횟수
    public Call<JsonObject> medicineCount(HashMap<String,String> hashMap){
        return retrofitApi.medicineCount(hashMap);
    }
}
