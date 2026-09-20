<?php

$text = '测试正则表达式。我爱财经，也爱科技频道。【财经|科技|体育】';

$matches = [];
// preg_match_all('/[财经|科技]/u', $text, $matches);
preg_match_all('/(财经|科技)/u', $text, $matches);

print_r($matches);
