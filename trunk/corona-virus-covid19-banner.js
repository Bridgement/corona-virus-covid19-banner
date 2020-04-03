jQuery(document).ready(function($) {
	const dismissed = localStorage.getItem("remove-covid-banner");

	if (!scriptParams.in_array && dismissed !== "true") {
		$(
			`
        <div id="covid-banner" class="covid-banner">
            <div class="covid-group">
                <div class="covid-img">
                    <img class="coat" src="${scriptParams.img_src}" style="background-color: transparent;">
                </div>
                <div class="covid-body">
                    <h2 class="covid-header">COVID-19</h2>
                    <p class="covid-text">Stay informed with official news &amp; stats:</p>
                    <a class="covid-link" href="https://sacoronavirus.co.za/"  target="_blank">
                        <span>SAcoronavirus.co.za</span>
                    </a>
				</div>
			</div>
			<div class="covid-footer">
				<button id="covid-banner-dismiss-button">Dismiss</button>
			</div>
        </div>`
		).prependTo("body");

		$("#covid-banner-dismiss-button").click(() => {
			$("#covid-banner").remove();
			localStorage.setItem("remove-covid-banner", "true");
		});

		var bodyPaddingLeft = $("body").css("padding-left");
		var bodyPaddingRight = $("body").css("padding-right");

		if (bodyPaddingLeft != "0px") {
			$("head").append(
				'<style type="text/css" media="screen">.covid-banner{margin-left:-' +
					bodyPaddingLeft +
					";padding-left:" +
					bodyPaddingLeft +
					";}</style>"
			);
		}
		if (bodyPaddingRight != "0px") {
			$("head").append(
				'<style type="text/css" media="screen">.covid-banner{margin-right:-' +
					bodyPaddingRight +
					";padding-right:" +
					bodyPaddingRight +
					";}</style>"
			);
		}
	}
});
