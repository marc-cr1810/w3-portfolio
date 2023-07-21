<?php
function formatContent($content)
{
    // Code blocks
    $content = str_replace("```CODE", "<pre><code>", $content);
    $content = str_replace("CODE```", "</code></pre>", $content);

    return $content;
}
?>