<x-app-layout>
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3">
            <h1 class="heading-normal">資産の編集</h1>
            <form action="/assets/{{ $assets['asset_id'] }}?_method=PUT" method="post" class="validated-form" novalidate>
                @csrf
                <div class="row align-items-center">
                    <label class="form-label" for="registration_date">登録日:</label>
                    <div class="mb-2">
                        <input class="form-control" type="date" name="registration_date" id="registration_date"
                            value="{{ $assets['registration_date'] }}" required>
                        <div class="valid-feedback">
                            OK!
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="asset_name">名称：</label>
                    <input class="form-control" type="text" id="asset_name" name="assets[asset_name]"
                        value="{{ $assets['asset_name'] }}" required>
                </div>
                <div class="valid-feedback">
                    OK!
                </div>
                <label for="categoryId">カテゴリ：</label>
                <select class="form-select mb-2" id="categoryId" name="assets[categoryId]" aria-label="カテゴリ" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}"
                            {{ $assets['categoryId'] == $category['id'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
                <div class="valid-feedback">
                    OK!
                </div>
                <label class="form-label" for="amount">金額：</label>
                <div class="input-group mb-2">
                    <span class="input-group-text">¥</span>
                    <input class="form-control" type="number" name="assets[amount]" id="amount"
                        value="{{ $assets['amount'] }}" required>
                    <span class="input-group-text">円</span>
                    <div class="valid-feedback">
                        OK!
                    </div>
                </div>
                <div class="d-grid my-3">
                    <button class="btn btn-outline-success">編集する</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
