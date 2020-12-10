<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?></title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- form-post -->
    <section class="post">
        <form action="/admin/posts" class="post__form" method="POST">
            <header class="post__header">

                <div class="post_actions">
                    <a href="#">Visualizar</a>
                    <button type="submit">Salvar</button>
                </div>

            </header>
            <label for="category">
                <select name="category" id="category">
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id() ?>"> <?= $category->description()?></option>
                    <?php endforeach ?>
                </select>
            </label>
            <label for="title">
                <span>Title:</span>
                <input type="text" name="title" id="title">
            </label>
            <label for="content">
                <span>Conteúdo:</span>
                <textarea name="content" id="content" cols="30" rows="20"></textarea>
            </label>
            <label for="image">
                <input type="file" name="image" id="image">
            </label>
        </form>
    </section>


    <!-- list-post -->
    <?php if (empty($posts)) : ?>
        <div class="post__list empty">
            Você ainda não criou nenhuma postagem. Crie agora mesmo.
        </div>
    <?php else : ?>
        <?php foreach ($posts as $post) : ?>
            <article class="post__card">
                <div class="post__card__header">
                    <h3><?= $post->title() ?></h3>
                    <span><?= $post->author()->name() ?></span>
                    <strong><?= $post->category()->parent() ? $post->category()->description()->parent()->description() . '>>' : '' . $post->category()->description() ?></strong>
                    <small>Publicado em: <?= $post->createdAt()->format('d/m/Y \à\s H:m:i') ?></small>
                </div>
                <p class="post__card__body">
                    <?= $post->content() ?>
                </p>
            </article>
        <?php endforeach ?>
    <?php endif ?>

</body>

</html>