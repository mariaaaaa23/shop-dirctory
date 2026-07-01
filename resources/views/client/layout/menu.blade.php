<div class="custom-menu-wrapper" dir="rtl">
    <ul class="main-nav">
        <li class="nav-item-dropdown">
            <a href="javascript:void(0)" class="nav-btn">
                <span>دسته‌بندی‌ها</span>
                <i class="arrow-down"></i>
            </a>
            
            <ul class="dropdown-content">
                @foreach ($categories->whereNull('category_id') as $parent)
                    <li class="has-submenu">
                        <a href="#" class="dropdown-link">
                            {{ $parent->title }}
                            @if($parent->children->count() > 0)
                                <span class="chevron-left">‹</span>
                            @endif
                        </a>
                        
                        @if($parent->children->count() > 0)
                            <ul class="submenu-right">
                                @foreach ($parent->children as $child)
                                    <li><a href="#" class="submenu-link">{{ $child->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</div>



<ul class="main-nav">
    <li class="nav-item-dropdown">
        <a href="javascript:void(0)" class="nav-btn">
            <span>برند ها</span>
            <i class="arrow-down"></i>
        </a>
        
        <ul class="dropdown-content">
            @foreach ($brands as $brand)
                <li class="has-submenu">
                    <a href="#" class="dropdown-link">
                        <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" title="{{ $brand->name }}" style="width: 70px; height: 30px; margin-right: 5px;">
                        {{ $brand->name }}
                        <span class="caret-right"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
</ul>
</div>



<style>
    /* ظرف اصلی */
    .custom-menu-wrapper {
        font-family: 'Tahoma', sans-serif;
    }
    .main-nav, .main-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* دکمه اصلی */
    .nav-btn {
        background-color: #3b82f6; /* آبی ملایم */
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: background 0.3s;
        font-weight: bold;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .nav-btn:hover { background-color: #2563eb; }

    /* استایل فلش کوچک */
    .arrow-down {
        border: solid white;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 3px;
        transform: rotate(45deg);
    }

    /* لیست کشویی اول */
    .nav-item-dropdown { position: relative; display: inline-block; }
    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        min-width: 200px;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-top: 8px;
        z-index: 1000;
        overflow: visible;
    }

    /* نمایش لیست اول با هاور */
    .nav-item-dropdown:hover > .dropdown-content { display: block; animation: fadeIn 0.2s; }

    /* آیتم‌های لیست */
    .dropdown-link {
        display: flex;
        justify-content: space-between;
        padding: 12px 16px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
        border-bottom: 1px solid #f3f4f6;
    }
    .dropdown-link:hover { background-color: #f9fafb; color: #3b82f6; padding-right: 20px; }

    /* زیرمنو سمت راست */
    .has-submenu { position: relative; }
    .submenu-right {
        display: none;
        position: absolute;
        top: 0;
        left: 100%; /* این باعث می‌شود به سمت راست (در دید فارسی) یا همان بیرونِ منو باز شود */
        margin-left: 5px;
        background-color: white;
        min-width: 180px;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        z-index: 1001;
    }

    /* نمایش زیرمنو با هاور روی والد */
    .has-submenu:hover > .submenu-right { display: block; animation: fadeIn 0.2s; }

    .submenu-link {
        display: block;
        padding: 10px 16px;
        color: #4b5563;
        text-decoration: none;
        font-size: 0.9em;
    }
    .submenu-link:hover { background-color: #f3f4f6; color: #3b82f6; }

    .chevron-left { font-size: 18px; color: #9ca3af; }
/* انیمیشن نرم */
@keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>