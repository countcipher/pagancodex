@props(['country' => '', 'stateProvince' => '', 'city' => '', 'allowEmpty' => true])

<div x-data="{ country: '{{ old('country', $country) }}' }">
    {{-- Country --}}
    <div class="form-group">
        <x-input-label for="country" :value="__('Country')" />
        <select id="country" name="country" class="form-input form-select" x-model="country"
            @change="if(country === '') { $refs.city.value = ''; $refs.state_us.value = ''; $refs.state_ca.value = ''; }">
            @if($allowEmpty)
                <option value="">Don't Show Location</option>
            @else
                <option value="" disabled selected hidden>— Select a country —</option>
            @endif
            <option value="US" {{ old('country', $country) === 'US' ? 'selected' : '' }}>United States</option>
            <option value="CA" {{ old('country', $country) === 'CA' ? 'selected' : '' }}>Canada</option>
        </select>
        <x-input-error :messages="$errors->get('country')" />
    </div>

    {{-- State / Province --}}
    <div class="form-group" x-show="country === 'US' || country === 'CA'" style="display: none;">
        <label class="form-label" x-text="country === 'US' ? 'State / Territory' : 'Province / Territory'">State</label>

        {{-- US States & Territories --}}
        <select x-show="country === 'US'" x-ref="state_us" :name="country === 'US' ? 'state_province' : ''"
            class="form-input form-select">
            <option value="">— Select a state —</option>
            @foreach(config('locations.states') as $abbr => $name)
                <option value="{{ $abbr }}" {{ old('state_province', $stateProvince) === $abbr ? 'selected' : '' }}>
                    {{ $name }}
                </option>

            @endforeach
        </select>

        {{-- Canadian Provinces & Territories --}}
        <select x-show="country === 'CA'" x-ref="state_ca" :name="country === 'CA' ? 'state_province' : ''"
            class="form-input form-select" style="display: none;">
            <option value="">— Select a province —</option>
            @foreach(config('locations.provinces') as $abbr => $name)
                <option value="{{ $abbr }}" {{ old('state_province', $stateProvince) === $abbr ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('state_province')" />
    </div>

    {{-- City --}}
    <div class="form-group" x-show="{{ $allowEmpty ? 'country !== \'\'' : 'true' }}"
        style="{{ $allowEmpty ? 'display: none;' : '' }}">
        <x-input-label for="city" :value="__('City')" />
        <x-text-input id="city" x-ref="city" type="text" name="city" value="{{ old('city', $city) }}"
            placeholder="Your city or nearest town" />
        <x-input-error :messages="$errors->get('city')" />
    </div>
</div>