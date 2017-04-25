//	设置为首页
function SetHome(obj, url) {
	try {
		obj.style.behavior = 'url(#default#homepage)';
		obj.setHomePage(url);
	} catch(e) {
		if(window.netscape) {
			try {
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			} catch(e) {
				alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
			}
		} else {
			alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【" + url + "】设置为首页。");
		}
	}
}
//收藏本站 
function AddFavorite(title, url) {
	try {
		window.external.addFavorite(url, title);
	} catch(e) {
		try {
			window.sidebar.addPanel(title, url, "");
		} catch(e) {
			alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
		}
	}
}

$(document).ready(function() {

	//	设置为首页
	$(".SetHome").click(function() {
		SetHome(this, "http://www.baidu.com");
	});
	//收藏本站 
	$(".AddFavorite").click(function() {
		AddFavorite("彩票通官网", location.href);
	});
	var serchHight = $(".serch-result-right").height();
	$(".serch-result-left").css("min-height", serchHight);

	//设置body的最低高度
	//  $("body").css("min-height",$(document).height());

	//	首页文章点击切换
	var a;
	$(".index-news-type li").each(function(a) {
		$(this).hover(function() {
			$(".index-news-type li").removeClass("active").eq(a).addClass("active");
			$(".index-news-box").removeClass("active").eq(a).addClass("active");
		});
	});

	//	彩票APP悬停切换
	var e;
	$(".lottery-app-type li").each(function(e) {
		$(this).hover(function() {
			$(".lottery-app-type li").removeClass("active").eq(e).addClass("active");
			$(".lottery-app-content").removeClass("active").eq(e).addClass("active");
		});
	});

	//	查看条件点击切换
	var b;
	$(".serch-condition a").each(function(b) {
		$(this).click(function() {
			$(".serch-condition a").removeClass("active").eq(b).addClass("active");
			$(".serch-condition a").removeClass("active").eq(b).addClass("active");
		});
	});

	//某产品项点击是发生
	var c;
	$(".product-list .product-list-item").each(function(c) {
		$(this).click(function() {
			$(".product-list .product-list-item").removeClass("product-list-item-click").eq(c).addClass("product-list-item-click");
			$(".product-list .product-list-item").removeClass("product-list-item-click").eq(c).addClass("product-list-item-click");
		});
	});

	//分类点击切换
	var d;
	$(".tag ul li a").each(function(d) {
		$(this).click(function() {
			$(".tag ul li a").removeClass("active").eq(d).addClass("active");
			$(".tag ul li a").removeClass("active").eq(d).addClass("active");
		});
	});

	$(".download-btn").click(function() {
		$("html body").animate({
			scrollTop: $($(this).attr("href")).offset().top + 'px'
		}, {
			duration: 500,
			easing: "swing"
		});
		return false;
	});
	$(".product-details a").click(function() {
		$("html body").animate({
			scrollTop: $($(this).attr("href")).offset().top + 'px'
		}, {
			duration: 200,
			easing: "swing"
		});
		return false;
	});

	//下载排行榜的hover效果
	var f;
	$(".leaderboard-link-item").each(function(f) {
		$(this).hover(function() {
			$(".leaderboard-link-item").removeClass("active").eq(f).addClass("active");
			$(".leaderboard-link-item").removeClass("active").eq(f).addClass("active");
		}, function() {
			$(".leaderboard-link-item").removeClass("active");
			$(".leaderboard-link-item").removeClass("active").eq(0).addClass("active");
		});
	})

	//	设置body全屏 滚动条样式悬浮在右边
	//	var w
	$("body").css("width", $(window).width());

	//返回顶部
	$(".small-feature-top").on("click", function() {
		$("body,html").animate({
			scrollTop: 0
		}, 500);
	});

	//	var bodyHeight = $("body").height();
	//	var pageTopHeight = $(".page-top").height();
	//	var footerHeight = $(".footer").outerHeight(true);
	//	var pageMiddleHeight = bodyHeight - pageTopHeight - footerHeight;
	//	console.log(pageMiddleHeight);
	//	$(".page-middle").css("min-height", pageMiddleHeight);
	$(".small-feature-top").css('bottom', '-100px');
});
$(window).scroll(function() {
	if(jQuery(this).scrollTop() > 100) {
		$(".small-feature-top").css('bottom', '60px');
	} else {
		$(".small-feature-top").css('bottom', '-100px');
	}
})