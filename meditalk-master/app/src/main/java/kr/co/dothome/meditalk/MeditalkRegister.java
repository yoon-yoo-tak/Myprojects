package kr.co.dothome.meditalk;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.webkit.JavascriptInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import kr.co.dothome.meditalk.request.RequestHttp;

public class MeditalkRegister extends AppCompatActivity {
    private WebView webView;
    @SuppressLint("JavascriptInterface")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meditalk_register);

        webView = findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.addJavascriptInterface(new AndroidBridge(),"android");
        webView.loadUrl(RequestHttp.getUrl()+"mobile/terms_use.html");
        webView.setWebChromeClient(new WebChromeClient());
        webView.setWebViewClient(new WebViewClient());
    }
    //js 통신
    class  AndroidBridge{
        @JavascriptInterface
        public void success(){
            Toast.makeText(getApplicationContext(),"회원가입 성공",Toast.LENGTH_LONG).show();
            finish();
        }
        @JavascriptInterface
        public void fail(){
            Toast.makeText(getApplicationContext(),"회원가입 실패",Toast.LENGTH_LONG).show();
        }
    }

    private class  WebViewClient extends android.webkit.WebViewClient{
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            view.loadUrl(url);
            return true;
        }
    }
}
