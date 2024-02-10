<x-app-layout>
  <div class="row mt-3">
    <div class="col-md-6 offset-md-3">
      <h1 class="heading-normal">資産の追加</h1>
      <form class="validated-form mb-2" method="post" novalidate>
        @csrf
        <div class="row align-items-center">
          <label class="form-label" for="registration_date">登録日:</label>
          <div class="mb-2">
            <input class="form-control" type="date" name="registration_date" id="registration_date" required>
            <div class="valid-feedback">
              OK!
            </div>
          </div>
        </div>
        <div class="mb-2">
          <label class="form-label" for="asset_input_name">名称：</label>
          @if(count($assets))
            <select class="form-select mb-2" id="asset_select_name" name="asset_name" aria-label="名称">
              @php
                $uniqueNames = array_unique(array_column($assets, 'asset_name'));
              @endphp
              @foreach($uniqueNames as $name)
                <option value="{{ $name }}">{{ $name }}</option>
              @endforeach
            </select>
          @endif
          <input class="form-control" type="text" id="asset_input_name" name="asset_name" placeholder="名称を入力してください" required>
          <div class="valid-feedback">
            OK!
          </div>
        </div>
        <label for="categoryId">カテゴリー：</label>
        <select class="form-select mb-2" id="categoryId" name="categoryId" aria-label="カテゴリ" required>
          @foreach($categories as $category)
            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
          @endforeach
        </select>
        <div class="valid-feedback">
          OK!
        </div>
        <label class="form-label" for="amount">金額：</label>
        <div class="input-group mb-2">
          <span class="input-group-text">¥</span>
          <input class="form-control" type="number" name="amount" id="amount" placeholder="金額を入力してください" required>
          <span class="input-group-text">円</span>
          <div class="valid-feedback">
            OK!
          </div>
        </div>
        <div class="d-grid">
          <button class="btn btn-outline-success">登録する</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>