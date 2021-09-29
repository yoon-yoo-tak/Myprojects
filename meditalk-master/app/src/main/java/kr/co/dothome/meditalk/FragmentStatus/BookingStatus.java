package kr.co.dothome.meditalk.FragmentStatus;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import kr.co.dothome.meditalk.R;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;


public class BookingStatus extends Fragment {
    WebView webView;
    DataRepository dataRepository;
    ImageView back_btn;
    @SuppressLint("JavascriptInterface")
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.booking_status,container,false);

        dataRepository = new DataRepository(getContext());

        webView = root.findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.loadUrl(RequestHttp.getUrl() + "mobile/booking_status.php?user_id="+dataRepository.getUserId());
        webView.setWebChromeClient(new WebChromeClient());
        webView.setWebViewClient(new WebViewClient());




        return root;
    }

    private class  WebViewClient extends android.webkit.WebViewClient{
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            view.loadUrl(url);
            return true;
        }
    }

}

