<?php use \Filament\Support\Facades\FilamentAsset; ?>
<?php
    $modal = $this->getConfigs()->getModal();
    
    $isRetainRecentIfFavorite = $this->getConfigs()->isRetainRecentIfFavorite();
    $maxItemsAllowed  =  $this->getConfigs()->getMaxItemsAllowed() ?? 10;
    $hasFooterView = $this->getConfigs()->hasFooterView();
    $footerView = $this->getConfigs()->getFooterView();
    $EmptyQueryView = $this->getConfigs()->getEmptyQueryView();
    
    // here I am going to force custom style for built-in filament modal
    $classes = [
        // there is lot of padding around the modal reduce it.
        '[&_.fi-modal-header]:!px-4 [&_.fi-modal-header]:!py-4', 
        
        // reduce also the padding of contents 
        '[&_.fi-modal-content]:!py-3 [&_.fi-modal-content]:!px-4', 

        // reduce top padding a little bit
        '[&_.fi-modal-window-ctn]:!grid-rows-[0.6fr_auto_1fr] [&_.fi-modal-window-ctn]:sm:!grid-rows-[0.5fr_auto_3fr]', 
  
        // give it some padding when the auto in "0.6fr_auto_1fr" expand across
        '[&_:not(.fi-modal-slide-over):not(.fi-width-screen)_.fi-modal-window-ctn]:!pt-16',

        // handle the close button 
        '[&_.fi-modal-close-btn]:!top-4 [&_.fi-modal-close-btn]:!end-4 [&_.fi-modal-close-btn]:!p-0.5 [&_.fi-modal-close-btn]:size-6 ',
        // control results container heights 
        '[&_:not(.fi-modal-slide-over):not(.fi-width-screen)_.results-container]:max-h-[67vh]', 
        '[&_.fi-modal-slide-over_.results-container]:!max-h-[80vh] [&_.fi-modal-slide-over_.results-container]:!min-h-full', 
        '[&_.fi-width-screen_.results-container]:!max-h-[80vh]', 

        // chrome scroll bar sucks (make it looks like what firefox does)
        '[&_.results-container]:[scrollbar-width:thin]',
        '[&_.results-container]:[scrollbar-color:rgba(156_,_163_,_175_,_0.7)_transparent]',
        '[&_.results-container::-webkit-scrollbar]:w-[6px]',
        '[&_.results-container::-webkit-scrollbar-thumb]:bg-gray-400/70',
        '[&_.results-container::-webkit-scrollbar-thumb]:rounded-full',
        '[&_.results-container::-webkit-scrollbar-thumb:hover]:bg-gray-500/90',
        '[&_.results-container::-webkit-scrollbar-track]:bg-transparent',
        'dark:[&_.results-container::-webkit-scrollbar-thumb]:bg-gray-500/70',
    ];
?>
<div>
    <div 
        x-load
        x-load-css="[<?php echo \Illuminate\Support\Js::from(FilamentAsset::getStyleHref('global-search-modal', 'charrafimed/global-search-modal'))->toHtml() ?>]" 
        x-load-src="<?php echo e(FilamentAsset::getAlpineComponentSrc('global-search-modal-observer', 'charrafimed/global-search-modal')); ?>"
        x-data="observer"
        class="<?php echo e(Arr::toCssClasses($classes)); ?>"
    >
    <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['id' => 'global-search-modal::plugin','openEventName' => 'open-global-search-modal','attributes' => new \Illuminate\View\ComponentAttributeBag([
            'width' => $modal->getWidth()?->value ?? Filament\Support\Enums\Width::TwoExtraLarge,
            'closeButton' => $modal->hasCloseButton(),
            'closedByClickingAway' => $modal->isClosedByClickingAway(),
            'closedByEscaping' => $modal->isClosedByEscaping(),
            'autofocus' => $modal->isAutofocus(),
            'slideOver' => $modal->isSlideOver(),
        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'global-search-modal::plugin','openEventName' => 'open-global-search-modal','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(new \Illuminate\View\ComponentAttributeBag([
            'width' => $modal->getWidth()?->value ?? Filament\Support\Enums\Width::TwoExtraLarge,
            'closeButton' => $modal->hasCloseButton(),
            'closedByClickingAway' => $modal->isClosedByClickingAway(),
            'closedByEscaping' => $modal->isClosedByEscaping(),
            'autofocus' => $modal->isAutofocus(),
            'slideOver' => $modal->isSlideOver(),
        ]))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('header', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginale5a491bf15391e893cf5b9a6405a19b3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5a491bf15391e893cf5b9a6405a19b3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.bar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5a491bf15391e893cf5b9a6405a19b3)): ?>
<?php $attributes = $__attributesOriginale5a491bf15391e893cf5b9a6405a19b3; ?>
<?php unset($__attributesOriginale5a491bf15391e893cf5b9a6405a19b3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5a491bf15391e893cf5b9a6405a19b3)): ?>
<?php $component = $__componentOriginale5a491bf15391e893cf5b9a6405a19b3; ?>
<?php unset($__componentOriginale5a491bf15391e893cf5b9a6405a19b3); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>

        <div class="results-container overflow-y-auto">
            <div     
                x-load
                x-load-src="<?php echo e(FilamentAsset::getAlpineComponentSrc('global-search-modal-search', 'charrafimed/global-search-modal')); ?>"
                x-data="searchComponent({
                    recentSearchesKey:  <?php echo \Illuminate\Support\Js::from($this->getPanelId() . "_recent_search")->toHtml() ?>,
                    favoriteSearchesKey: <?php echo \Illuminate\Support\Js::from($this->getPanelId() . "_favorites_search")->toHtml() ?>,
                    maxItemsAllowed:  <?php echo \Illuminate\Support\Js::from($maxItemsAllowed)->toHtml() ?>,
                    retainRecentIfFavorite : <?php echo \Illuminate\Support\Js::from($isRetainRecentIfFavorite)->toHtml() ?>
                })"
            >
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! (empty($search))): ?>
                    <?php if (isset($component)) { $__componentOriginale1c74538c624595cbacb616a9146e18f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1c74538c624595cbacb616a9146e18f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.results','data' => ['results' => $results]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['results' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($results)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1c74538c624595cbacb616a9146e18f)): ?>
<?php $attributes = $__attributesOriginale1c74538c624595cbacb616a9146e18f; ?>
<?php unset($__attributesOriginale1c74538c624595cbacb616a9146e18f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1c74538c624595cbacb616a9146e18f)): ?>
<?php $component = $__componentOriginale1c74538c624595cbacb616a9146e18f; ?>
<?php unset($__componentOriginale1c74538c624595cbacb616a9146e18f); ?>
<?php endif; ?>
                <?php else: ?>
                    <div
                        class="w-full"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! (filled($EmptyQueryView))): ?>
                            <div>                            
                                <template x-if="search_history.length <=0 && favorite_items.length <=0">
                                    <p class="text-gray-700 p-4 dark:text-gray-200 text-center"><?php echo e(__('Please enter a search term to get started.')); ?></p>
                                </template>
                            </div>
                        <?php else: ?>
                            <div>
                                <template x-if="search_history.length <=0 && favorite_items.length <=0">
                                    <div>     
                                        <?php echo $EmptyQueryView->render(); ?>

                                    </div>
                                </template>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala5d720e82b9ef010351119d08e72fe81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5d720e82b9ef010351119d08e72fe81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.summary.summary-wrapper','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.summary.summary-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala5d720e82b9ef010351119d08e72fe81)): ?>
<?php $attributes = $__attributesOriginala5d720e82b9ef010351119d08e72fe81; ?>
<?php unset($__attributesOriginala5d720e82b9ef010351119d08e72fe81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala5d720e82b9ef010351119d08e72fe81)): ?>
<?php $component = $__componentOriginala5d720e82b9ef010351119d08e72fe81; ?>
<?php unset($__componentOriginala5d720e82b9ef010351119d08e72fe81); ?>
<?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>  
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasFooterView): ?>
             <?php $__env->slot('footer', null, []); ?> 
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! (filled($footerView))): ?>
                        <?php if (isset($component)) { $__componentOriginalf9b38aaae2e27749580d8de253289837 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf9b38aaae2e27749580d8de253289837 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf9b38aaae2e27749580d8de253289837)): ?>
<?php $attributes = $__attributesOriginalf9b38aaae2e27749580d8de253289837; ?>
<?php unset($__attributesOriginalf9b38aaae2e27749580d8de253289837); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf9b38aaae2e27749580d8de253289837)): ?>
<?php $component = $__componentOriginalf9b38aaae2e27749580d8de253289837; ?>
<?php unset($__componentOriginalf9b38aaae2e27749580d8de253289837); ?>
<?php endif; ?>    
                <?php else: ?>
                    <?php echo $footerView->render(); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             <?php $__env->endSlot(); ?>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $attributes = $__attributesOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__attributesOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $component = $__componentOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__componentOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>    
</div>
 <?php if (isset($component)) { $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.modals','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-actions::modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $attributes = $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $component = $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
</div>
<?php /**PATH /var/www/html/vendor/charrafimed/global-search-modal/resources/views/components/global-search-modal.blade.php ENDPATH**/ ?>