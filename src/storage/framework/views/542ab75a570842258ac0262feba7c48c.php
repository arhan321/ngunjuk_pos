<div
x-data="{
    handleKeyUp(){
        const focusedEl = $focus.focused();
        
        // If at first element, go to search input
        if($focus.getFirst() === focusedEl){
            document.getElementById('search-input').focus();
            return;
        }
        
        // If on action button, check if it's first action in the li
        if (focusedEl.hasAttribute('data-action')) {
            const parentLi = focusedEl.closest('li');
            const actions = parentLi.querySelectorAll('[data-action]');
            if (actions[0] === focusedEl) {
                // Focus the link in the same li
                parentLi.querySelector('a').focus();
                return;
            }
        }
        
        $focus.previous();
    },
    
    handleKeyDown(){
        const focusedEl = $focus.focused();
        
        // If on link (a tag), go to first action if it exists
        if(focusedEl.tagName === 'A'){
            const actions = focusedEl.closest('li').querySelectorAll('[data-action]');
            if(actions.length > 0){
                actions[0].focus();
                return;
            }
        }
        
        $focus.wrap().next(); 
    }
}"   
x-on:focus-first-element.window="$focus.first()"
x-on:keydown.up.stop.prevent="handleKeyUp()"
x-on:keydown.down.stop.prevent="handleKeyDown()" 
class="global-search-modal w-full">
    <template x-if="search_history.length > 0">
        <div>
            <div class="top-0 z-10">
                <h3
                    class="relative flex flex-1 flex-col justify-center overflow-x-hidden text-ellipsis whitespace-nowrap px-4 py-2 text-start text-[0.9em] font-semibold capitalize text-violet-600 dark:text-violet-500   ">
                    <?php echo e(__('recent')); ?>

                </h3>
            </div>
            <ul x-animate>
                <template x-for="(result,index) in search_history">
                    <?php if (isset($component)) { $__componentOriginal4f766de0c6d45c5aa9a658cb094647a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.summary.item','data' => ['xBind:key' => 'index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.summary.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-bind:key' => 'index']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <span x-html="result.title" />
                         <?php $__env->slot('actions', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal59a1b5e5a955254ded729f78ce0291a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.action-button','data' => ['title' => 'delete','xOn:click.stop' => 'deleteFromHistory(result.title, result.group)','icon' => \Filament\Support\Icons\Heroicon::OutlinedXMark]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'delete','x-on:click.stop' => 'deleteFromHistory(result.title, result.group)','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::OutlinedXMark)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $attributes = $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $component = $__componentOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal59a1b5e5a955254ded729f78ce0291a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.action-button','data' => ['title' => 'favorite this item','xOn:click.stop' => 'addToFavorites(result.title, result.group, result.url)','icon' => \Filament\Support\Icons\Heroicon::OutlinedStar]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'favorite this item','x-on:click.stop' => 'addToFavorites(result.title, result.group, result.url)','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::OutlinedStar)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $attributes = $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $component = $__componentOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0)): ?>
<?php $attributes = $__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0; ?>
<?php unset($__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4f766de0c6d45c5aa9a658cb094647a0)): ?>
<?php $component = $__componentOriginal4f766de0c6d45c5aa9a658cb094647a0; ?>
<?php unset($__componentOriginal4f766de0c6d45c5aa9a658cb094647a0); ?>
<?php endif; ?>
                </template>
            </ul>
        
    </div>
</template>
<template x-if="favorite_items.length > 0">
    <div>
        <div class="top-0 z-10">
            <h3
                class="relative flex flex-1 flex-col justify-center overflow-x-hidden text-ellipsis whitespace-nowrap px-4 py-2 text-start text-[0.9em] font-semibold capitalize text-violet-600 dark:text-violet-500   ">
                <?php echo e(__('favorites')); ?>

            </h3>
        </div>
        <ul x-animate>
            <template x-for="(result,index) in favorite_items">
                <?php if (isset($component)) { $__componentOriginal4f766de0c6d45c5aa9a658cb094647a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.summary.item','data' => ['xBind:key' => 'index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.summary.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-bind:key' => 'index']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <span x-html="result.title">
                    </span>
                     <?php $__env->slot('actions', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginal59a1b5e5a955254ded729f78ce0291a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.action-button','data' => ['title' => 'delete','xOn:click.stop' => 'deleteFromFavorites(result.title, result.group)','icon' => \Filament\Support\Icons\Heroicon::OutlinedXMark]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'delete','x-on:click.stop' => 'deleteFromFavorites(result.title, result.group)','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::OutlinedXMark)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $attributes = $__attributesOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__attributesOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1)): ?>
<?php $component = $__componentOriginal59a1b5e5a955254ded729f78ce0291a1; ?>
<?php unset($__componentOriginal59a1b5e5a955254ded729f78ce0291a1); ?>
<?php endif; ?>
                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0)): ?>
<?php $attributes = $__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0; ?>
<?php unset($__attributesOriginal4f766de0c6d45c5aa9a658cb094647a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4f766de0c6d45c5aa9a658cb094647a0)): ?>
<?php $component = $__componentOriginal4f766de0c6d45c5aa9a658cb094647a0; ?>
<?php unset($__componentOriginal4f766de0c6d45c5aa9a658cb094647a0); ?>
<?php endif; ?>
            </template>
        </ul>
</div>
</template>
</div>
<?php /**PATH /var/www/html/vendor/charrafimed/global-search-modal/resources/views/components/search/summary/summary-wrapper.blade.php ENDPATH**/ ?>