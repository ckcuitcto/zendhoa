/**
 * Created by Thai Duc on 13-Mar-18.
 */

function confirm_delete_product() {
    if(!window.confirm("Bạn có thực sự muốn xoá sản phẩm này ?")){
        return false;
    }else{
        return true;
    }
}