<?php
defined('_JEXEC') or die();

JImport('b0.Post.Post');
JImport('b0.Company.CompanyConfig');
JImport('b0.fixtures');

$post = new Post($this->item, $this->user);
$this->document->setTitle($post->metaTitle);
$this->document->setMetaData('description', $post->metaDescription);
JLayoutHelper::render('b0.openGraph', ['og' => $post->openGraph, 'doc' => $this->document]);

/** @var JRegistry $paramsRecord */
$paramsRecord = $this->tmpl_params['record'];
?>

<article class="uk-article" itemscope itemtype="http://schema.org/NewsArticle">
    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <meta itemprop="url" content="<?= $post->image['url'];?>" />
        <meta itemprop="image" content="<?= $post->image['url'];?>" />
        <meta itemprop="height" content="<?= $post->image['height'];?>px" />
        <meta itemprop="width" content="<?= $post->image['width'];?>px" />
    </div>
    <meta itemprop="description" content="<?= $post->metaDescription;?>" />
    <meta itemprop="keywords" content="<?= $post->metaKey;?>"/>
    <meta itemprop="about" content="<?= $post->announcement;?>" />
    <meta itemprop="dateCreated" content="<?= $post->cTime;?>" />
    <meta itemprop="dateModified" content="<?= $post->mTime;?>"/>
    <meta itemprop="datePublished" content="<?= $post->cTime;?>" />
    <meta itemprop="author" content="<?= $post->siteName;?>" />
    <div itemprop="publisher"  itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?= CompanyConfig::COMPANY_NAME; ?>" />
        <meta itemprop="address" content="<?= CompanyConfig::COMPANY_ADDRESS; ?>" />
        <meta itemprop="telephone" content="<?= CompanyConfig::COMPANY_TELEPHONE; ?>" />
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <meta itemprop="url" content="<?= CompanyConfig::COMPANY_LOGO; ?>" />
            <meta itemprop="image" content="<?= CompanyConfig::COMPANY_LOGO; ?>" />
            <meta itemprop="height" content="<?= CompanyConfig::COMPANY_LOGO_HEIGHT; ?>" />
            <meta itemprop="width" content="<?= CompanyConfig::COMPANY_LOGO_WIDTH; ?>" />
        </div>
    </div>
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?= $post->url;?>"/>

    <?php if($post->controls){
        echo JLayoutHelper::render('b0.controls', $post->controls);
    }?>

    <header itemprop="headline">
        <?php $post->renderTitle();?>
    </header>
	<hr class="uk-article-divider">
	<p class="uk-article-meta">
		<?php $post->renderCTime();?>
	</p>
    <div itemprop="articleBody" <?= (isset($post->image)) ? 'style="min-height: 310px;"' : ''; ?>>
	    <?php $post->renderImage();?>
	    <?php $post->renderBody();?>
    </div>
    <div class="uk-clearfix"></div>

	<?php $post->renderGallery();?>
	<?php $post->renderVideo();?>

    <hr class="uk-article-divider">
    <noindex>
        <div>{module <?= $paramsRecord->get('tmpl_core.module_mini_banners');?>}</div>
        <footer class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-large-top">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="uk-text-small">
			        <?php $post->renderHits();?>
                </div>
                <div>
			        <?php $post->renderRating();?>
                </div>
                <div>
	                <?= JLayoutHelper::render('b0.discuss', ['href' => CompanyConfig::COMPANY_VK_LINK, 'src' => CompanyConfig::COMPANY_VK_ICON]);?>
                </div>
                <div>
			        <?php $post->renderSocial();?>
                </div>
            </div>
        </footer>
    </noindex>
</article>
