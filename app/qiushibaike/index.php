<?php

$configs = parse_ini_file("config.ini",true);

$spider = new phpspider($configs);

$spider->on_start = function()
{
    requests::add_cookie("name", "yangzetao");
};

$spider->on_handle_img = function($fieldname, $img)
{
    $regex = '/src="(https?:\/\/.*?)"/i';
    preg_match($regex, $img, $rs);
    if (!$rs)
    {
        return $img;
    }

    $url = $rs[1];
    $img = $url;
    return $img;
};

$spider->on_extract_field = function($fieldname, $data, $page)
{
    if ($fieldname == 'article_title')
    {
        if (strlen($data) > 10)
        {
            // 下面方法截取中文会有异常
            //$data = substr($data, 0, 10)."...";
            $data = mb_substr($data, 0, 10, 'UTF-8')."...";
        }
    }
    elseif ($fieldname == 'article_publish_time')
    {
        // 用当前采集时间戳作为发布时间
        $data = time();
    }
    // 把当前内容页URL替换上面的field
    elseif ($fieldname == 'url')
    {
        $data = $page['url'];
    }
    return $data;
};

$spider->start();
