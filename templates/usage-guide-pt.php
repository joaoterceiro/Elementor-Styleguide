<?php
/**
 * Usage guide in Portuguese
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="usage-guide" style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
    <h2>Guia de Uso</h2>
    
    <h3>Como Usar as Cores</h3>
    <p>Adicione estas classes aos elementos do Elementor:</p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>color-primary</code>, <code>color-primary-light</code>, <code>color-primary-dark</code> - Para cores de texto primárias</li>
        <li><code>color-secondary</code>, <code>color-secondary-light</code>, <code>color-secondary-dark</code> - Para cores de texto secundárias</li>
        <li><code>color-accent</code>, <code>color-accent-light</code>, <code>color-accent-dark</code> - Para cores de destaque</li>
        <li><code>color-success</code>, <code>color-warning</code>, <code>color-danger</code>, <code>color-info</code> - Para cores de status</li>
        <li><code>bg-primary</code>, <code>bg-primary-light</code>, <code>bg-primary-dark</code> - Para cores de fundo primárias</li>
        <li><code>bg-secondary</code>, <code>bg-secondary-light</code>, <code>bg-secondary-dark</code> - Para cores de fundo secundárias</li>
        <li><code>bg-accent</code>, <code>bg-accent-light</code>, <code>bg-accent-dark</code> - Para cores de fundo de destaque</li>
        <li><code>bg-success</code>, <code>bg-warning</code>, <code>bg-danger</code>, <code>bg-info</code> - Para cores de fundo de status</li>
        <li><code>color-gray-100</code> até <code>color-gray-900</code> - Para tons de cinza em texto</li>
        <li><code>bg-gray-100</code> até <code>bg-gray-900</code> - Para tons de cinza em fundo</li>
        <li><code>border-primary</code>, <code>border-secondary</code>, etc. - Para bordas coloridas</li>
    </ul>

    <h3>Como Usar a Tipografia</h3>
    <p>Classes de tamanho de fonte:</p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>display-large</code> - 80px (64px tablet, 48px mobile)</li>
        <li><code>display-small</code> - 72px (56px tablet, 40px mobile)</li>
        <li><code>heading-h1</code> até <code>heading-h6</code> - Títulos hierárquicos</li>
        <li><code>text-xl</code> - 18px</li>
        <li><code>text-lg</code> - 16px</li>
        <li><code>text-md</code> - 14px</li>
        <li><code>text-sm</code> - 12px</li>
    </ul>

    <p>Classes de peso da fonte:</p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>font-regular</code> - Peso 400</li>
        <li><code>font-medium</code> - Peso 500</li>
        <li><code>font-semibold</code> - Peso 600</li>
        <li><code>font-bold</code> - Peso 700</li>
    </ul>
    
    <p>Classes de altura de linha:</p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>lh-tight</code> - Altura de linha 1.2</li>
        <li><code>lh-normal</code> - Altura de linha 1.5</li>
        <li><code>lh-loose</code> - Altura de linha 1.8</li>
    </ul>
    
    <p>Classes de alinhamento de texto:</p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>text-left</code>, <code>text-center</code>, <code>text-right</code>, <code>text-justify</code></li>
    </ul>

    <h3>Como Aplicar</h3>
    <ol style="margin-left: 20px;">
        <li>No editor do Elementor, selecione o elemento que deseja estilizar</li>
        <li>Na aba "Avançado", encontre o campo "Classes CSS"</li>
        <li>Adicione as classes desejadas (por exemplo: "color-primary font-bold")</li>
    </ol>
    
    <h3>Exemplos de Uso</h3>
    <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 15px;">
        <p><strong>Para um título grande em cor primária:</strong></p>
        <code>heading-h1 color-primary font-bold</code>
        
        <p style="margin-top: 15px;"><strong>Para um botão secundário:</strong></p>
        <code>bg-secondary text-lg font-semibold</code>
        
        <p style="margin-top: 15px;"><strong>Para um alerta ou aviso:</strong></p>
        <code>bg-warning color-gray-900 text-md lh-normal</code>
    </div>
    
    <h3>Dicas e Melhores Práticas</h3>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li>Mantenha consistência usando as mesmas variantes de cores em todo o site</li>
        <li>Use as cores em tons de cinza para a maioria do conteúdo e as cores de destaque com moderação</li>
        <li>Combine várias classes para obter o estilo desejado</li>
        <li>Use as cores de status de forma apropriada para transmitir significado (sucesso, aviso, etc.)</li>
    </ul>
</div>