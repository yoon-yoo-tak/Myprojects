package kr.co.dothome.meditalk.repository;

import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;

public class DataRepository {
    SharedPreferences pref;

    public DataRepository(Context context){
        pref = PreferenceManager.getDefaultSharedPreferences(context);
    }
    public void setUserId(String id){
        SharedPreferences.Editor editor = pref.edit();
        editor.putString("user_id",id);
        editor.commit();
    }
    public String getUserId(){
        return pref.getString("user_id","");
    }
    public void setUserName(String name){
        SharedPreferences.Editor editor = pref.edit();
        editor.putString("user_name",name);
        editor.commit();
    }
    public String getUserName(){
        return pref.getString("user_name","");
    }

    public void setUserEmail(String email){
        SharedPreferences.Editor editor = pref.edit();
        editor.putString("user_email",email);
        editor.commit();
    }
    public String getUserEmail(){
        return pref.getString("user_email","");
    }

    public void logout(){
        SharedPreferences.Editor editor = pref.edit();
        editor.remove("user_id");
        editor.remove("user_name");
        editor.remove("user_email");
        editor.commit();
    }

}
