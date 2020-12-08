<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?></title>
</head>
<body>
    <!-- form-post -->
    <section class="post">
        <form action="" class="post__form">
            <header class="post__header">

                <div class="post_actions">
                    <a href="#">Visualizar</a>
                    <button type="submit">Salvar</button>
                </div>
                
            </header>        
            <label for="content">
                <textarea name="content" id="content" cols="30" rows="20"></textarea>
            </label>
            <label for="image">
                <input type="file" name="image" id="image">
            </label>
        </form>
    </section>

    
    <!-- list-post -->
</body>
</html>