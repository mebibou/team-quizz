<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Team Quizz - API Documentation</title>
  <!--[if lt IE 9]>
  <script src="http://s2.wp.com/wp-content/themes/a8c/newdash/js/html5.js?m=1333681055g" type="text/javascript"></script>
  <![endif]-->
  <link rel='stylesheet' id='all-css-0' href='http://s1.wp.com/_static/??-eJxtjMEOwiAQRH9IXBqbRg/Gb6GwBVpgiSzh94tealJvM5n3BloWmhJjYohV5FCtTwVinoRTevtJV13KBf7jwW9YYEXOnRTfdsLnQPYQyFo0VFksFAI1aN5Y5JPEDmN/diOwmgv0GRwqg+8P+YrP4XYfJzlI+Vh3ytdJkg==' type='text/css' media='all' />
  <link rel='stylesheet' id='h5-font-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600' type='text/css' media='all' />
  <link rel='stylesheet' id='all-css-2' href='http://s0.wp.com/_static/??-eJy1jTsSAiEQBS8kjp91JbE8ywgjYAFD7cxKeXs1MHPNjF7Srxt6M46rUlXQSIUE0Dqo1D1KBNFHprUTWcF3sDfHxdN9t4CW2bQ8h1QFGouaa8Y0/U0bcUo1fHYpEAcImS+Yf2l78oFU4IVAYPYToZf34VxO270d7HE8jJvbE+rLdh8=' type='text/css' media='all' />
  <link rel='stylesheet' id='screen-css-2' href='http://s2.wp.com/wp-content/plugins/bbpress/templates/default/css/bbpress.css?m=1375386506g' type='text/css' media='screen' />
  <style>
    /* <![CDATA[ */
    /* Block: reblog */

    .reblog-from img                   { margin: 0 10px 0 0; vertical-align: middle; padding: 0; border: 0; }
    .reblogger-note img.avatar         { float: left; padding: 0; border: 0; }
    .reblogger-note-content            { margin: 0 0 20px; }
    .reblog-post .wpcom-enhanced-excerpt-content { border-left: 3px solid #eee; padding-left: 15px; }
    .reblog-post ul.thumb-list         { display: block; list-style: none; margin: 2px 0; padding: 0; clear: both; }
    .reblog-post ul.thumb-list li      { display: inline; margin: 0; padding: 0 1px; border: 0; }
    .reblog-post ul.thumb-list li a    { margin: 0; padding: 0; border: 0; }
    .reblog-post ul.thumb-list li img  { margin: 0; padding: 0; border: 0; }

    .reblog-post .wpcom-enhanced-excerpt { clear: both; }

    .reblog-post .wpcom-enhanced-excerpt address,
    .reblog-post .wpcom-enhanced-excerpt li,
    .reblog-post .wpcom-enhanced-excerpt h1,
    .reblog-post .wpcom-enhanced-excerpt h2,
    .reblog-post .wpcom-enhanced-excerpt h3,
    .reblog-post .wpcom-enhanced-excerpt h4,
    .reblog-post .wpcom-enhanced-excerpt h5,
    .reblog-post .wpcom-enhanced-excerpt h6,
    .reblog-post .wpcom-enhanced-excerpt p { font-size: 100% !important; }

    .reblog-post .wpcom-enhanced-excerpt blockquote,
    .reblog-post .wpcom-enhanced-excerpt pre,
    .reblog-post .wpcom-enhanced-excerpt code,
    .reblog-post .wpcom-enhanced-excerpt q { font-size: 98% !important; }

    .wpcom-reblog-snapshot .reblogged-content { max-height: 400px; overflow-y: scroll; }
    .wpcom-reblog-snapshot .reblogger-note { margin-top: 15px; margin-bottom: 15px; border-top: 1px solid #eee; }
    .wpcom-reblog-snapshot .reblogger-headline { margin-top: 15px; }
    .wpcom-reblog-snapshot .reblogger-headline img.avatar { float: none; margin: 0 15px; vertical-align: middle; padding: 0; }

    .site-header hgroup { background: #1f2d50 url('<?php bloginfo('template_directory'); ?>/images/tardis.png') no-repeat bottom right; }

    .site-header hgroup, .site-header .site-title a, .site-header .site-title a:hover { text-shadow: none; }
    .github-logo { background: url('<?php bloginfo('template_directory'); ?>/images/github.png') no-repeat; padding-left: 20px; margin-left: 6px; }

    .api-index td.api-index-item-title, .api-index td.api-index-item-body { width: 33%; }

    .api-index td.api-index-item-body strong { font-weight: bold; }
    .api-index td.api-index-item-body .parameter-type { font-style: italic; }

    td.api-index-return { font-family: monospace, monospace; _font-family: 'courier new', monospace; font-size: 1em; padding: 9px 0 78px; border: none; }
    .api-index-item-body.json { font-family: monospace, monospace; _font-family: 'courier new', monospace; font-size: 1em; }

    td.api-index-return span.api-method-return {
      font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
      margin: 0 5px 0 2px;
      background: #BF1E4B;
      color: #FFF;
      padding: 0px 3px;
      display: inline-block;
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      -o-border-radius: 2px;
      -ms-border-radius: 2px;
      border-radius: 2px;
    }

    /* ]]> */
  </style>
  <link rel="stylesheet" id="custom-css-css" type="text/css" href="http://s0.wp.com/?custom-css=1&#038;csblog=2gHKz&#038;cscache=6&#038;csrev=6" />
</head>
<body class="page page-id-16 page-parent page-child parent-pageid-8 page-template page-template-api-doc-index-php typekit-enabled mp6 highlander-enabled highlander-dark">

<div id="page" class="hfeed site">
  <header id="sitehead" class="site-header" role="banner">
    <hgroup>
      <h1 class="site-title"><a href="http://developer.wordpress.com/" title="Developer Resources" rel="home">Team Quizz API</a></h1>
      <h2 class="site-description">Developer documentation</h2>
    </hgroup>
  </header><!-- #sitehead .site-header -->

  <div id="main" class="main">
    <div class="breadcrumbs">Documentation template forked from wordpress API. Thanks guys.</div>
  <div id="primary" class="content-area full-width">
    <div id="content" class="site-content" role="main">
      <article class="post hentry api-index">
        <header class="entry-header">
          <h1 class="entry-title">Rest API</h1>
        </header><!-- .entry-header -->
        <div class="entry-content">

          <div class="api-index-wrap">
            <p>You can use this REST API to make browser extensions. Each action and JSON object are described.</p>
            <hr />
            <div id="jp-post-flair" class="sharedaddy sharedaddy-dark sd-like-enabled sd-sharing-enabled"></div>
            <table class="api-index api-index-users">
              <caption>
                <h2>JSON Objects</h2>
                <p>Objects that are used in return actions.</p>
              </caption>
              <thead>
                <tr>
                  <th class="api-index-title" style="width: 17%;">Resource</th>
                  <th class="api-index-title" style="width: 50%;">Data</th>
                  <th class="api-index-title">Description</th>
                </tr>
              </thead>
              <tbody>

                <tr class="api-index-item">
                  <td class="api-index-item-title" style="width: 17%;">
                    <span class="api-method-get">UserObject</span>
                  </td>
                  <td class="api-index-item-body json" style="width: 50%;">{"username": (string), "avatar": (string), "points": (int)}</td>
                  <td class="api-index-item-body">User meta data object.</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title" style="width: 17%;">
                    <span class="api-method-get">QuizzObject</span>
                  </td>
                  <td class="api-index-item-body json" style="width: 50%;">{"id": (int), "participateTime": (int), "respondTime": (int), "question": (string), "answers": {"A": (string), "B": (string), "C": (string), "D": (string), ...}}</td>
                  <td class="api-index-item-body">Quizz meta data object.</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title" style="width: 17%;">
                    <span class="api-method-get">QuizzResultObject</span>
                  </td>
                  <td class="api-index-item-body json" style="width: 50%;">{"date": (string), "winner": (UserObject), "members": [(UserObject), ...], "message": (string)}</td>
                  <td class="api-index-item-body">Quizz result meta data object.</td>
                </tr>

              </tbody>
            </table>

            <table class="api-index api-index-sites">
              <caption>
                <h2>Actions</h2>
                <p>All actions to use quizz.</p>
              </caption>
              <thead>
                <tr>
                  <th class="api-index-title">Resource</th>
                  <th class="api-index-title">Parameters</th>
                  <th class="api-index-title">Description</th>
                </tr>
              </thead>

              <tbody>
                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/avatars" title="/avatars">
                    <span class="api-method-get">GET</span>/avatars</a>
                  </td>
                  <td class="api-index-item-body"></td>
                  <td class="api-index-item-body">Return a list with all avatars availables for users.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"avatars": [(string), (string), ...]}</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/register/" title="/register/&lt;channel&gt;">
                    <span class="api-method-post">POST</span>/register/&lt;channel&gt;</a>
                  </td>
                  <td class="api-index-item-body">
                    <p><strong>username</strong> <span class="parameter-type">(string)</span> Name of the user to register for this channel.</p>
                    <p><strong>avatar</strong> <span class="parameter-type">(string)</span> Full avatar URL of the user to register.</p>
                  </td>
                  <td class="api-index-item-body">Register a new channel and new user if they do not exists.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"success": (bool) [, "error": (string)]}</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/play/" title="/play/&lt;channel&gt;">
                    <span class="api-method-get">GET</span>/play/&lt;channel&gt;</a>
                  </td>
                  <td class="api-index-item-body">
                    <p><strong>username</strong> <span class="parameter-type">(string)</span> Name of the user to get quizz for this channel.</p>
                  </td>
                  <td class="api-index-item-body">Get quizz or last quizz result for the current user in the current channel.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"quizz": (QuizzObject or null), "quizzResult": (QuizzResultObject or null), "points": (int)}</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/answer/" title="/answer/&lt;channel&gt;">
                    <span class="api-method-post">POST</span>/answer/&lt;channel&gt;</a>
                  </td>
                  <td class="api-index-item-body">
                    <p><strong>username</strong> <span class="parameter-type">(string)</span> Name of the user for this channel.</p>
                    <p><strong>answer</strong> <span class="parameter-type">(string)</span> Response letter for the last quiz.</p>
                    <p><strong>time</strong> <span class="parameter-type">(int)</span> User response time in milliseconds.</p>
                  </td>
                  <td class="api-index-item-body">Answer action for the last quizz taken.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"success": (bool) [, "error": (string)}</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/results/" title="/results/&lt;channel&gt;">
                    <span class="api-method-get">GET</span>/results/&lt;channel&gt;</a>
                  </td>
                  <td class="api-index-item-body">
                    <p><strong>count</strong> <span class="parameter-type">(int)</span> Number of the results returned.</p>
                  </td>
                  <td class="api-index-item-body">Get the last X results for the channel.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"results": [(QuizzResultObject), ...]}</td>
                </tr>

                <tr class="api-index-item">
                  <td class="api-index-item-title">
                    <a href="/scores/" title="/scores/&lt;channel&gt;">
                    <span class="api-method-get">GET</span>/scores/&lt;channel&gt;</a>
                  </td>
                  <td class="api-index-item-body"></td>
                  <td class="api-index-item-body">Get all the users scores for the channel.</td>
                </tr>
                <tr class="api-index-item">
                  <td colspan="3" class="api-index-return"><span class="api-method-return">RETURN JSON</span> {"scores": [(UserObject), ...]}</td>
                </tr>

              </tbody>
            </table>
          </div><!-- .api-index-wrap -->

        </div><!-- .entry-content -->
      </article><!-- .api-index -->
    </div><!-- #content -->
  </div><!-- #primary -->


      </div><!-- #main -->

  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info">
      You can fork the project on <a href="https://github.com/XavierBoubert/team-quizz" title="Team Quizz on GitHub" class="github-logo">GitHub</a></div><!-- .site-info -->
  </footer><!-- .site-footer .site-footer -->
</div><!-- #page .hfeed .site -->

  <div id="bit" class="loggedout-follow-normal">
    <a class="bsub" href="javascript:void(0)"><span id='bsub-text'>Follow</span></a>
    <div id="bitsubscribe">

      <h3><label for="loggedout-follow-field">Follow &ldquo;Developer Resources&rdquo;</label></h3>

      <form action="https://subscribe.wordpress.com" method="post" accept-charset="utf-8" id="loggedout-follow">
      <p>Get every new post delivered to your Inbox.</p>

      <p id="loggedout-follow-error" style="display: none;"></p>

            <p class="bit-follow-count">Join 1,780 other followers</p>
      <p><input type="email" name="email" value="Enter your email address" onfocus='this.value=(this.value=="Enter your email address") ? "" : this.value;' onblur='this.value=(this.value=="") ? "Enter email address" : this.value;'  id="loggedout-follow-field"/></p>

      <input type="hidden" name="action" value="subscribe"/>
      <input type="hidden" name="blog_id" value="33534099"/>
      <input type="hidden" name="source" value="http://developer.wordpress.com/docs/api/"/>
      <input type="hidden" name="sub-type" value="loggedout-follow"/>

      <input type="hidden" id="_wpnonce" name="_wpnonce" value="b42b7fab1b" /><input type="hidden" name="_wp_http_referer" value="/docs/api/" />
      <p id='bsub-subscribe-button'><input type="submit" value="Sign me up" /></p>
      </form>
          <div id='bsub-credit'><a href="http://wordpress.com/signup/?ref=lof">Powered by WordPress.com</a></div>
    </div><!-- #bitsubscribe -->
  </div><!-- #bit -->
</body>
</html>