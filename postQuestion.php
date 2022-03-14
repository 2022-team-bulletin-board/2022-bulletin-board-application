<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!--  css-link  -->
    <link rel="stylesheet" href="./css/framework/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

    <link rel="stylesheet" href="./css/color.css">
    <link rel="stylesheet" href="./css/postQuestion.css">
    <!--  css-link-end  -->
    <title>質問投稿</title>
</head>
<body>
<section class="main section">
    <div class="is-8-widescreen is-10-tablet is-offset-2-widescreen is-offset-1-tablet is-centered column">
        <div class="field">
            <div class="control">
                <h2 class="subtitle has-text-left control is-size-4 mb-3">タイトル</h2>
            </div>
            <div class="control">
                <input
                        type="text"
                        class="input is-expanded"
                >
            </div>
        </div>
        <div class="field">
            <div class="control">
                <h2 class="subtitle has-text-left control is-size-4 mb-3">本文</h2>
            </div>
            <div class="control content">
                <textarea id="easyMDE" name="" cols="30" rows="10"></textarea>
            </div>
        </div>
<!--        tag input area-->
<!--        <div class="field">-->
<!--            <div class="control">-->
<!--                <h2 class="subtitle has-text-left control is-size-4 mb-3">タグ</h2>-->
<!--            </div>-->
<!--            <div class="control">-->
<!--                <input-->
<!--                        type="text"-->
<!--                        class="input is-expanded"-->
<!--                >-->
<!--            </div>-->
<!--        </div>-->
<!--        end area-->
        <div class="field has-text-right">
            <button id="postButton" class="button is-large">質問する</button>
        </div>
    </div>
</section>

<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
<script>
    let easyMDE = new EasyMDE({
        element: document.getElementById('easyMDE')
    });
</script>
</body>
</html>