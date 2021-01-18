<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    $flass = (new App\Core\Session\FlashMessage);
    $errors = $flass->get('errors') ?? null;
    if ($errors) :
    ?>
        <div class="alert alert-danger" role="alert">
            <p>
                Verifique as seguites informações:
            </p>
            <?php foreach ($errors->all() as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <!-- form-post -->
    <section class="mx-3">
        <form action="/admin/posts" class="col-md-4" method="POST">
            <header class="my-2 d-flex justify-content-between">
                <h3>Escreva seu artigo aqui</h3>
                <div class="btn-group" role="group" aria-label="actions post">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>

            </header>
            <div class="mb-2">
                <label for="category" class="form-label">Categoria do artigo</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id() ?>"> <?= $category->description() ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-2">
                <label for="title">Título</label>
                <input type="text" 
                        name="title" 
                        id="title" 
                        class="form-control <?= ($errors && $errors->has('title')) ? 'border border-danger' : '' ?>">
                <?php if ($errors && $errors->has('title')) : ?>
                    <div class="text-danger">
                        <?= $errors->first('title') ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="mb-2">
                <label for="image">Informe a foto do artigo</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="mb-2">
                <label for="content">Escreva seu artigo aqui</label>
                <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
            </div>
        </form>
    </section>


    <!-- list-post -->
    <section class="mx-3 mt-3">
        <h3>Minhas postagens (<?= $posts->count() ?>) </h3>
        <?php if ($posts->isEmpty()) : ?>
            <div class="card">
                Você ainda não criou nenhuma postagem. Crie agora mesmo.
            </div>
        <?php else : ?>
            <?php foreach ($posts as $post) : ?>
                <article class="card mb-2">
                    <div class="card-head p-3">
                        <h3><?= $post->title() ?></h3>
                        <span><?= $post->author()->name() ?></span>
                        <strong><?= $post->category()->parent() ? $post->category()->description()->parent()->description() . '>>' : '' . $post->category()->description() ?></strong>
                        <small>Publicado em: <?= $post->createdAt()->format('d/m/Y \à\s H:m:i') ?></small>
                    </div>
                    <p class="card-body">
                        <?= $post->content() ?>
                    </p>
                </article>
            <?php endforeach ?>
        <?php endif ?>
    </section>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>