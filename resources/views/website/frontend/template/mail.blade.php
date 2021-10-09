@lang('english.VERIFICATION_MAIL_ADDRESS', ['name' => $name])
@lang('english.VERIFICATION_MAIL_BODY', ['title' => $title, 'code' => $code])

<br>
@lang('english.VERIFICATION_MAIL_REGARDS')
<img src="{{ $message->embed(public_path() . '/img/swapnoloke.png') }}" alt="@lang('english.COMPANY_NAME_SL')" />
@lang('english.VERIFICATION_MAIL_COMPANY_INFO')