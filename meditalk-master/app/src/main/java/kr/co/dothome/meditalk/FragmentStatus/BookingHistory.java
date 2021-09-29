package kr.co.dothome.meditalk.FragmentStatus;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.JavascriptInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import kr.co.dothome.meditalk.R;
import kr.co.dothome.meditalk.onlineBooking.OnlineBooking;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;


public class BookingHistory extends Fragment {
    WebView webView;
    DataRepository dataRepository;
    @SuppressLint("JavascriptInterface")
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        
        View root = inflater.inflate(R.layout.booking_history,container,false);
        dataRepository = new DataRepository(getContext());

        webView = root.findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.addJavascriptInterface(new AndroidBridge(), "android");
        webView.loadUrl(RequestHttp.getUrl() + "mobile/booking_history.php?user_id="+dataRepository.getUserId());
        webView.setWebChromeClient(new WebChromeClient());
        webView.setWebViewClient(new WebViewClient());
        return root;
    }
    public class AndroidBridge {
        @JavascriptInterface
        public void onlineBooking(String hp_id){
            Intent intent = new Intent(getContext(), OnlineBooking.class);
            intent.putExtra("keyword","rebook");
            intent.putExtra("hp_id",hp_id);
            getContext().startActivity(intent);
            getActivity().finish();
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
