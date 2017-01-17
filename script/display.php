<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link href="src/bootstrap-table.css" rel="stylesheet">
<script src="src/jquery.js" type="text/javascript"></script>
<script src="src/bootstrap-table.js" type="text/javascript"></script>

<style>

tr:nth-child(odd) {
    background-color: white;
}

tr:nth-child(even) {
    background-color: #b0cedd;
}
</style>
</head>

<body>

<script type="text/javascript">



jQuery(document).ready(function(){
	$.ajax({
		type : "get",
		async:false, 
		url : "http://42.159.26.226:8082/api/web/v1/site/outputgrade", 
		dataType : "jsonp", 
		jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(默认为:callback) 
		jsonpCallback:"success_jsonpCallback",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名 
		success : function(json){
			
			mydate=new Date;
			$('#header').html('<h1>nps统计   =>  ' + mydate.toLocaleString() + '</h1>');
			$('#count').html('<h3>填写总人数：' + json.length + '</h3>');
			$('#table').bootstrapTable({
				data: json
			});
		}, 
		error:function(){
			alert('获取失败');
		}
	});
});
</script>

<div id="header"></div>
<div id="count"></div>
<table id="table">
    <thead>
    <tr>
        <th data-field="id">数据库ID</th>
        <th data-field="grade">打分</th>
        <th data-field="checkbox">多选</th>
        <th data-field="note">用户备注</th>
        <th data-field="create_time">填写时间</th>
    </tr>
    </thead>
</table>
</body>
</html>