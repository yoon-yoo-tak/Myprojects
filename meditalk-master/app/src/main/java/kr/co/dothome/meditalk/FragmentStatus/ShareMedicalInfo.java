package kr.co.dothome.meditalk.FragmentStatus;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.JavascriptInterface;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.kakao.kakaolink.v2.KakaoLinkResponse;
import com.kakao.kakaolink.v2.KakaoLinkService;
import com.kakao.message.template.ContentObject;
import com.kakao.message.template.FeedTemplate;
import com.kakao.message.template.LinkObject;
import com.kakao.network.ErrorResult;
import com.kakao.network.callback.ResponseCallback;

import java.util.HashMap;
import java.util.Map;

import kr.co.dothome.meditalk.R;
import kr.co.dothome.meditalk.repository.DataRepository;
import kr.co.dothome.meditalk.request.RequestHttp;


public class ShareMedicalInfo extends Fragment {
    WebView webView;
    DataRepository dataRepository;
    @SuppressLint("JavascriptInterface")
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        dataRepository = new DataRepository(getContext());
        View root = inflater.inflate(R.layout.share_medical_info,container,false);
        String userId = dataRepository.getUserId();
        String url = RequestHttp.getUrl() + "mobile/share_medicalinfo.php?user_id="+userId;
        webView = root.findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.addJavascriptInterface(new AndroidBridge(), "android");
        webView.loadUrl(url);
        webView.setWebChromeClient(new WebChromeClient());
        webView.setWebViewClient(new WebViewClient());

        return root;
    }
    public class AndroidBridge {
        @JavascriptInterface
        public void shareMedicalinfo(String pk) {

            FeedTemplate params = FeedTemplate
                    .newBuilder(ContentObject.newBuilder("????????????",
                            "http://meditalk.dothome.co.kr/info/img/img"+pk+".png",
                            LinkObject.newBuilder().setWebUrl("http://meditalk.dothome.co.kr/info/medicalinfo_view.php?pk="+pk)
                                    .setMobileWebUrl("http://meditalk.dothome.co.kr/info/medicalinfo_view.php?pk="+pk).build())
                            .build())
                    .build();

            Map<String, String> serverCallbackArgs = new HashMap<String, String>();
            serverCallbackArgs.put("user_id", "${current_user_id}");
            serverCallbackArgs.put("product_id", "${shared_product_id}");

            KakaoLinkService.getInstance().sendDefault(getContext(), params, serverCallbackArgs, new ResponseCallback<KakaoLinkResponse>() {
                @Override
                public void onFailure(ErrorResult errorResult) {


                    Toast.makeText(getContext(),errorResult.toString(),Toast.LENGTH_LONG).show();
                    Log.d("error",errorResult.toString());
                }

                @Override
                public void onSuccess(KakaoLinkResponse result) {
                    // ????????? ?????????????????? ?????? ????????? ??????????????? ??????. ????????? ??????????????? ??????????????? ????????? ??? ??? ??????. ?????? ?????? ????????? ???????????? ????????? ??????????????? ??????.
                    Toast.makeText(getContext(),"??????",Toast.LENGTH_LONG).show();
                }
            });


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
