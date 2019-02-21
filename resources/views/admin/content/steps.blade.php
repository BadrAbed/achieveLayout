<section class="timeline">

    <div class="container timeline_container">

        <div class="section01">
            <div class="flex flex-ali-ctr notification success">
                <div class="success-icon"></div>
                <div class="flex flex-ali-ctr flex-juc-ctr flex-col">
                    <p class="h4">ملء المحتوي</p>
                    <p class="small-font hint-msg">تم ارسال البيانات بنجاح</p>
                </div>
            </div>
        </div>
        <div class="section02">
            <div class="flex flex-ali-ctr notification info">
                <div class="line"><div class="info-icon"></div></div>
                <div class="flex flex-ali-ctr flex-juc-ctr flex-col">
                    <p class="h4">ملء الاسئلة</p>
                    <p class="small-font hint-msg">جارى ملء البيانات</p>
                </div>
            </div>
        </div>
        <div class="section03">
            <div class="flex flex-ali-ctr notification waiting">
                <div class="line"><div class="waiting-icon"></div></div>
                <div class="flex flex-ali-ctr flex-juc-ctr flex-col">
                    <p class="h4">ملء المصطلحات</p>
                    <p class="small-font hint-msg hint-color">انتظار ملء البيانات</p>
                </div>
            </div>
        </div>
        @if($errors and $errors->has('meaning'))
            <div class="section04">
                <div class="flex flex-ali-ctr notification error">
                    <div class="line"><div class="error-icon"></div></div>
                    <div class="flex flex-ali-ctr flex-juc-ctr flex-col">
                        <p class="h4">خطاء</p>
                        <p class="small-font hint-msg">خطاء فى الارسال</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>