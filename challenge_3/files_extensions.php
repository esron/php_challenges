<?php

$files = [
    'music.mp4',
    'video.mov',
    'imagem.jpeg',
];

$extensions = array_map(fn ($file) => (
    explode('.', $file)[1]
), $files);

sort($extensions);

foreach ($extensions as $extension) {
    echo ".$extension\n";
}
