package kr.co.dothome.meditalk.request;


import com.google.gson.JsonObject;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;


public interface RetrofitApi {
    //로그인
    @FormUrlEncoded
    @POST("mobile/Login.php/")
    Call<JsonObject> login(@FieldMap HashMap<String, String> param);

    //회원정보 수정
    @FormUrlEncoded
    @POST("mobile/mypage/modify_user.php/")
    Call<JsonObject> modifyUser(@FieldMap HashMap<String, String> param);

    //비밀번호 변경
    @FormUrlEncoded
    @POST("mobile/mypage/modify_pw.php/")
    Call<JsonObject> modifyPassword(@FieldMap HashMap<String, String> param);

    //회원탈퇴
    @FormUrlEncoded
    @POST("mobile/mypage/member_with.php/")
    Call<JsonObject> memberWithdrawal(@FieldMap HashMap<String, String> param);

    //예약 정보
    @FormUrlEncoded
    @POST("mobile/online_booking/booking_info.php/")
    Call<JsonObject> bookingInfo(@FieldMap HashMap<String, String> param);
    //약 횟수
    @FormUrlEncoded
    @POST("mobile/medicine_count.php/")
    Call<JsonObject> medicineCount(@FieldMap HashMap<String, String> param);
}

