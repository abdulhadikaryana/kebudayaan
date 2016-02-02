<div class="post_share">
    <?php if(eff_option('fb_share')) { ?>
    <span title="Facebook" class="tip_s">
        <i class="fb-share"></i>
        <a target="_new" href="https://www.facebook.com/sharer/sharer.php?u=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>">Facebook</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('twitter_share')) { ?>
    <span title="Twitter" class="tip_s">
        <i class="twitter-share"></i>
        <a target="_new" href="http://twitter.com/home?status=<?php print(urlencode(the_title())); ?>+<?php print(urlencode(get_permalink())); ?>">Twitter</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('plus_share')) { ?>
    <span title="Google+" class="tip_s">
        <i class="google-share"></i>
        <a target="_new" href="https://plus.google.com/share?url=<?php print(urlencode(get_permalink())); ?>">Google+</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('pin_share')) { ?>
    <span title="Pinterest" class="tip_s">
        <i class="pin-share"></i>
        <a target="_new" href="http://pinterest.com/pin/create/bookmarklet/?media=[MEDIA]&url=<?php print(urlencode(get_permalink())); ?>&is_video=false&description=<?php print(urlencode(the_title())); ?>">Pinterest</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('reddit_share')) { ?>
    <span title="Reddit" class="tip_s">
        <i class="reddit-share"></i>
        <a target="_new" href="http://www.reddit.com/submit?url=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>">Reddit</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('stumble_share')) { ?>
    <span title="StumbleUpon" class="tip_s">
        <i class="stumble-share"></i>
        <a target="_new" href="http://www.stumbleupon.com/submit?url=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>">StumbleUpon</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('linkedin_share')) { ?>
    <span title="Linkedin" class="tip_s">
        <i class="linkedin-share"></i>
        <a target="_new" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>&source=<?php home_url(); ?>">Linkedin</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('slashdot_share')) { ?>
    <span title="Slashdot" class="tip_s">
        <i class="slashdot-share"></i>
        <a target="_new" href="http://slashdot.org/bookmark.pl?url=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>">Slashdot</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('tumblr_share')) { ?>
    <span title="Tumblr" class="tip_s">
        <i class="tumblr-share"></i>
        <a target="_new" href="http://www.tumblr.com/share?v=3&u=<?php print(urlencode(get_permalink())); ?>&t=<?php print(urlencode(the_title())); ?>">Tumblr</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('googleb_share')) { ?>
    <span title="Google Bookmarks" class="tip_s">
        <i class="googleb-share"></i>
        <a target="_new" href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>&annotation=<?php bloginfo('description'); ?>">Google Bookmarks</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('newsvine_share')) { ?>
    <span title="Newsvine" class="tip_s">
        <i class="newsvine-share"></i>
        <a target="_new" href="http://www.newsvine.com/_tools/seed&save?u=<?php print(urlencode(get_permalink())); ?>&h=<?php print(urlencode(the_title())); ?>">Newsvine</a>
    </span>
    <?php } ?>	
    <?php if(eff_option('evernote_share')) { ?>
    <span title="Evernote" class="tip_s">
        <i class="evernote-share"></i>
        <a target="_new" href="http://www.evernote.com/clip.action?url=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>">Evernote</a>
    </span>
    <?php } ?>
    <?php if(eff_option('email_share')) { ?>
    <span title="Email" class="tip_s">
        <i class="email-share"></i>
        <a href="mailto:?subject=I wanted you to see this Link&amp;body=Check out this site<?php print(urlencode(get_permalink())); ?>.">Email</a>
    </span>
    <?php } ?>
</div>