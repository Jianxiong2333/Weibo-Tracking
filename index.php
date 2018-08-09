<?php
/**
 * Created by PhpStorm.
 * User: Jianxiong2333
 * Date: 2018-08-06
 * Time: 19:32
 */
date_default_timezone_set("Asia/Shanghai");//上海时间
class weibo{
    public $url_api = "https://m.weibo.cn/api/container/getIndex?containerid=ID";
    public $api_json;//以上API ID格式为：主页用230283+博主ID,微博内容用107603+博主ID
    //必须字段
    public $weibo_head;//微博头部：微博编号、微博字数、发布ID、抓取时间
    public $weibo_body;//微博信息：微博链接、发布时间、微博内容、发布设备
    public $weibo_user;//主页信息：发布昵称、主页头像、主页链接、微博等级、微博签名
    //非必须字段
    public $weibo_image;//微博图片九宫格0-8
    public $retweeted_head;//转发头部：转发id、转发粉丝
    public $retweeted_body;//转发信息：转发内容、转发时间、转发昵称、转发签名

    public function __construct($wb_id){
        $this -> api_json = file_get_contents($this -> url_api );//读取api数据
        $this -> api_json = json_decode($this -> api_json, true);//转为数组
        //头部
        $this -> weibo_head[0] = $this -> api_json['data']['cards'][$wb_id]['mblog']['id'];//微博编号
        $this -> weibo_head[1] = $this -> api_json['data']['cards'][$wb_id]['mblog']['textLength'];//微博字数
        $this -> weibo_head[2] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['id'];//发布ID
        $this -> weibo_head[3] = date('ymdHi');//抓取时间，两位年月日分
        //信息
        $this -> weibo_body[0] = $this -> api_json['data']['cards'][$wb_id]['scheme'];//微博链接
        $this -> weibo_body[1] = $this -> api_json['data']['cards'][$wb_id]['mblog']['created_at'];//发布时间
        $this -> weibo_body[2] = $this -> api_json['data']['cards'][$wb_id]['mblog']['text'];//微博内容
        $this -> weibo_body[2] = str_replace('\'',"\"",$this -> weibo_body[2]);//替换引号
        $this -> weibo_body[3] = $this -> api_json['data']['cards'][$wb_id]['mblog']['source'];//发布设备
        //主页
        $this -> weibo_user[0] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['screen_name'];//发布昵称
        $this -> weibo_user[1] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['profile_image_url'];//主页头像
        $this -> weibo_user[2] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['profile_url'];//主页链接
        $this -> weibo_user[3] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['statuses_count'];//微博等级
        $this -> weibo_user[4] = $this -> api_json['data']['cards'][$wb_id]['mblog']['user']['description'];//微博签名
        //九宫格
        for($i = 0; $i < 9; $i++)
        {
            if(isset($this -> api_json ['data']['cards'][$wb_id]['mblog']['pics'][$i]))//检测图片下标是否存在
                $this -> weibo_image[$i] = $this -> api_json['data']['cards'][$wb_id]['mblog']['pics'][$i]['large']['url'];//写下标链接
            else
                $this -> weibo_image[$i] = '';//写空
        }
        //转发
        if(isset($this -> api_json ['data']['cards'][$wb_id]['mblog']['retweeted_status']))//检测转发是否存在
        {
            $this -> retweeted_head[0] = $this -> api_json['data']['cards'][$wb_id]['mblog']['retweeted_status']['user']['id'];//转发ID
            $this -> retweeted_head[1] = $this -> api_json['data']['cards'][$wb_id]['mblog']['retweeted_status']['user']['followers_count'];//转发粉丝
            $this -> retweeted_body[0] = $this -> api_json ['data']['cards'][$wb_id]['mblog']['retweeted_status']['text'];//转发内容
            $this -> retweeted_body[1] = $this -> api_json['data']['cards'][$wb_id]['mblog']['retweeted_status']['created_at'];//转发时间
            $this -> retweeted_body[2] = $this -> api_json['data']['cards'][$wb_id]['mblog']['retweeted_status']['user']['screen_name'];//转发昵称
            $this -> retweeted_body[3] = $this -> api_json['data']['cards'][$wb_id]['mblog']['retweeted_status']['user']['description'];//转发签名
        }
    }

    public function __destruct(){
        //防止空数据
        if(empty($this -> weibo_head[0])) {
            echo"空数据";
            return;//关闭
        }
        //数据库信息
        $mysql_server = "0.0.0.0";
        $mysql_username = "xx";
        $mysql_password = "*****";
        $mysql_database = "xx";
        //连接数据库
        @$conn = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_database) or die("数据通信存在异常...");
        //指定字符集
        mysqli_query($conn, "set names 'utf8'");
        //微博查重
        $sql = "select * from weibo_save where wb_id = " . $this -> weibo_head[0];//查编号
        $res = $conn -> query($sql);//执行语句
        if(mysqli_num_rows($res) != 0){
            $conn->close(); //关闭数据库
            return;//关闭
        }
        //插入数据
        $sql = "INSERT INTO weibo_save(
        wb_id, wb_url, wb_time, get_time, wb_text, wb_textLength, wb_source, wb_userid, wb_username, wb_profile_image, wb_profile_url, wb_statuses, wb_description, 
        wb_image1_url, wb_image2_url, wb_image3_url, wb_image4_url, wb_image5_url, wb_image6_url, wb_image7_url, wb_image8_url, wb_image9_url, wb_retweeted_text,
        wb_retweeted_time, wb_retweeted_id, wb_retweeted_name, wb_retweeted_description, wb_retweeted_count
        ) VALUES ('" .
            $this -> weibo_head[0] . "','" . $this -> weibo_body[0] . "','" . $this -> weibo_body[1] . "','" . $this -> weibo_head[3]  . "','" . $this -> weibo_body[2] . "','" .
            $this -> weibo_head[1] . "','" . $this -> weibo_body[3] . "','" . $this -> weibo_head[2] . "','" . $this -> weibo_user[0] . "', '" . $this -> weibo_user[1] . "', '" .
            $this -> weibo_user[2] . "','" . $this -> weibo_user[3] . "','" . $this -> weibo_user[4] . "','" . $this -> weibo_image[0] . "', '" . $this -> weibo_image[1] . "', '" .
            $this -> weibo_image[2] . "','" . $this -> weibo_image[3] . "','" . $this -> weibo_image[4] . "','" . $this -> weibo_image[5] . "','" . $this -> weibo_image[6] . "', '" .
            $this -> weibo_image[7] . "','" . $this -> weibo_image[8] . "','" . $this -> retweeted_body[0] . "','" . $this -> retweeted_body[1] . "','" . $this -> retweeted_head[0] . "', '" .
            $this -> retweeted_body[2] . "','" . $this -> retweeted_body[3] . "','" . $this -> retweeted_head[1] . "'
        )";
        $conn->query($sql); //插入数据
        $conn->close(); //关闭数据库
        /** 邮件发送类
         * 以下代码来自 woider 以及 PHPMailer 项目
         * 在此致谢
         */
        require_once 'PHPMailer/SendMailer.php';
        // 实例化SendMailer
        $mailer = new QQMailer(true);
        // 邮件标题
        $title = '你的小姐姐更新微博啦，去看看吧！！！';
        $content ="<p>你的小姐姐：<a href=\"".$this -> weibo_user[2]."\">@".$this -> weibo_user[0]."</a> 在 ".$this -> weibo_body[1]." 更新微博说：<Br><Br>“".$this -> weibo_body[2]."”<Br><Br>以上内容来自新浪微博公开信息。</p>";
        // 发送QQ邮件
        $mailer->send('******@qq.com', $title, $content);
    }
}
$weibo_zhang = new weibo(0);
//print_r($weibo_zhang -> api_json);