@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.tos') }} ::
@parent
@endsection

{{-- Page content --}}
@section('content')

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Terms text
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section">
    <div class="container">
        <p>By signing up for any of the services ("Service") of AnyShare Society ("AnyShare") you are agreeing to be bound by the following terms and conditions ("Terms"). The Service offered by AnyShare under the Terms include Sharing Networks and any new features or tools which are added to the current Service.</p>

        <p>AnyShare reserves the right to update and change the Terms by posting updates and changes to the AnyShare website. You are advised to check the Terms of Service from time to time for any updates or changes that may impact you.</p>

        <p>You must read, agree with, and accept all of the terms and conditions contained in this Terms agreement and AnyShare’s <a href="/privacy">Privacy Policy</a> before you may become an AnyShare user.</p>

        <h6 class="heading-alt">Account Terms</h6>

        <ol>
            <li>You must be 18 years or older or at least the age of majority in the jurisdiction where you reside or from which you use this Service.</li>

            <li>To access and use the Service, you must sign-up for a AnyShare account ("Account") by providing your full legal name, a valid email address, and any other information indicated as required. AnyShare may reject your application for an Account, or cancel an existing Account, for any reason, in our sole discretion.</li>

            <li>You acknowledge that AnyShare will use the email address you provide as the primary method for communication.</li>

            <li>You are responsible for keeping your password secure. AnyShare cannot and will not be liable for any loss or damage from your failure to maintain the security of your Account and password.</li>

            <li>You are responsible for all activity and content such as data, graphics, photos and links that is uploaded under your Account. You must not transmit any worms or viruses or any code of a destructive nature.</li>

            <li>A breach or violation of any term in the Terms as determined in the sole discretion of AnyShare will result in an immediate termination of your services.</li>
        </ol>

        <h6 class="heading-alt">Account Activation</h6>

        <ol>
            <li>The person signing up for the Service will be the contracting party ("Account Owner") for the purposes of our Terms, and will be the person who is authorized to use any corresponding account we may provide to the Account Owner in connection with the Service.</li>
            <li>If you are signing up for the Service on behalf of your employer, your employer shall be the Account Owner. If you are signing up for the Service on behalf of your employer, then you represent and warrant that you have the authority to bind your employer to our Terms.</li>
        </ol>

        <h6 class="heading-alt">General Conditions</h6>

        <p>You must read, agree with and accept all of the terms and conditions contained in these Terms and the <a href="/privacy">Privacy Policy</a> before you may become a member of AnyShare.</p>

        <ol>
            <li>Technical support is only provided to paying Account holders and is only available via email.</li>
            <li>The Terms shall be governed by and interpreted in accordance with the laws of the State of Delaware and the laws of USA applicable therein, without regard to principles of conflicts of laws. The parties irrevocably and unconditionally submit to the exclusive jurisdiction of the courts of the State of Delaware with respect to any dispute or claim arising out of or in connection with the Terms. The United Nations Convention on Contracts for the International Sale of Goods will not apply to these Terms of Service and is hereby expressly excluded.</li>
            <li>You acknowledge and agree that AnyShare may amend these Terms at any time by posting the relevant amended and restated Terms on AnyShare’s website, available at <a href="/terms">terms</a>. Amendments to the Terms are effective as of the date of posting. Your continued use of the Services after the amended Terms are posted to AnyShare’s website constitutes your agreement to, and acceptance of, the amended Terms. If you do not agree to any changes to the Terms, do not continue to use the Service.</li>
            <li>You may not use the Service for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws), the laws applicable to you in your customer’s jurisdiction, or the laws of USA and the State of Delaware. You will comply with all applicable laws, rules and regulations in your use of the Service.</li>
            <li>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by AnyShare.</li>
            <li>You shall not purchase search engine or other pay per click keywords (such as Google AdWords), or domain names that use AnyShare or AnyShare trademarks and/or variations and misspellings thereof.</li>
            <li>Questions about the Terms should be sent to info@anyshare.coop</li>
            <li>You understand that your disclosed information (not including credit card information), may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices. Credit Card information is always encrypted during transfer over networks.</li>
            <li>You acknowledge and agree that your use of the Service, including information transmitted to or stored by AnyShare, is governed by its privacy policy at <a href="/privacy">privacy</a></li>
            <li>AnyShare requires that the Terms and all documents relating thereto be drawn up in English.</li>
        </ol>

        <h6 class="heading-alt">AnyShare Rights</h6>

        <ol>
            <li>We reserve the right to modify or terminate the Service for any reason, without notice, at any time.</li>
            <li>We reserve the right to refuse service to anyone for any reason at any time.</li>
            <li>We may, but have no obligation to, remove User Content and Accounts containing content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms.</li>
            <li>Verbal or written abuse of any kind (including threats of abuse or retribution) of any AnyShare customer, AnyShare employee, member, or officer will result in immediate Account termination.</li>
            <li>AnyShare does not pre-screen User Content and it is in our sole discretion to refuse or remove any User Content that is available via the Service.</li>
            <li>We reserve the right to provide our services to your competitors and make no promise of exclusivity in any particular market segment. You further acknowledge and agree that AnyShare employees and contractors may also be AnyShare customers/merchants and that they may compete with you, although they may not use your confidential information in doing so.</li>
            <li>In the event of a dispute regarding Account ownership, we reserve the right to request documentation to determine or confirm Account ownership. Documentation may include, but is not limited to, a scanned copy of your business license, government issued photo ID, the last four digits of the credit card on file, etc.</li>
            <li>AnyShare retains the right to determine, in our sole judgment, rightful Account ownership and transfer an Account to the rightful owner. If we are unable to reasonably determine the rightful Account owner, AnyShare reserves the right to temporarily disable an Account until resolution has been determined between the disputing parties.</li>
        </ol>

        <h6 class="heading-alt">Limitation of Liability</h6>

        <ol>
            <li>You expressly understand and agree that AnyShare shall not be liable for any direct, indirect, incidental, special, consequential or exemplary damages, including but not limited to, damages for loss of profits, goodwill, use, data or other intangible losses resulting from the use of or inability to use the service.</li>
            <li>You agree to indemnify, defend and hold AnyShare, its affiliates, subsidiaries, directors, officers, employees and suppliers (collectively "Indemnified Person(s)") harmless from and against any and all third party claims and any related liability, loss, and expense (including damage awards, settlement amounts, and reasonable legal fees), brought against any Indemnified Person(s), arising out of, related to or which may arise from Your breach of the terms and conditions of this Agreement or in relation to the Service or any business, activity or transactions carried out or performed on the Service.</li>
            <li>In no event shall AnyShare or our suppliers be liable for lost profits or any special, incidental or consequential damages arising out of or in connection with our site, our services or these Terms (however arising including negligence). You agree to indemnify and hold the Indemnified Person(s) harmless from any claim or demand, including reasonable attorneys' fees, made by any third party due to or arising out of your breach of these Terms or the documents it incorporates by reference, or your violation of any law or the rights of a third party.</li>
            <li>Your use of the Service is at your sole risk. The Service is provided on an "as is" and "as available" basis without any warranty or condition, express, implied or statutory.</li>
            <li>AnyShare does not warrant that the Service will be uninterrupted, timely, secure, or error-free.</li>
            <li>AnyShare does not warrant that the results that may be obtained from the use of the Service will be accurate or reliable.</li>
            <li>AnyShare does not warrant that the quality of any products, services, information, or other material purchased or obtained by you through the Service will meet your expectations, or that any errors in the Service will be corrected.</li>
        </ol>

        <h6 class="heading-alt">Waiver and Complete Agreement</h6>

        <p>The failure of AnyShare to exercise or enforce any right or provision of the Terms shall not constitute a waiver of such right or provision. The Terms constitutes the entire agreement between you and AnyShare and governs your use of the Service, superseding any prior agreements between you and AnyShare (including, but not limited to, any prior versions of the Terms).</p>

        <h6 class="heading-alt">Intellectual Property and Customer Content</h6>

        <ol>
            <li>You retain any copyright that you may have in Your Content.</li>
            <li>You hereby agree that Your Content:
                <ol type="a">
                    <li>is hereby licensed under the Creative Commons Attribution Non-Commercial 4.0 License and may be used under the terms of that license or any later version of a Creative Commons Attribution License, or </li>
                    <li>is in the public domain (such as Content that is not copyrightable or Content you make available under CC0), or </li>
                    <li>if not owned by you, (i) is available under a Creative Commons Attribution Non-Commercial 4.0 License or (ii) is a media file that is available under any Creative Commons license or (iii) that you are authorized by law to post or share through any the Service, such as under the fair use doctrine, and that is prominently marked as being subject to third party copyright.</li>
                </ol>
            </li>
        </ol>

        <h6 class="heading-alt">Payment of Fees</h6>

        <ol>
            <li>AnyShare may charge You the mutually agreed fees for the use of the Service. If any fees are chargeable for the Service, they shall be charged from You monthly or at other mutually agreed intervals.</li>
            <li>Unless and to the extent expressly indicated otherwise, listed fees and any amounts payable are net amounts exclusive of possibly applicable sales tax, or any other applicable taxes and charges imposed by any government entity in connection with Your use of the Service. You are liable for any any such taxes and charges.</li>
            <li>If a payment is late from its due date, then AnyShare has the right to suspend the provision of the Service temporarily until the payment is made.</li>
            <li>AnyShare reserves the right to change pricing when needed. AnyShare shall notify You of a change in the fees for the Service at least 30 days in advance and You will have the right to not  accept the change in fees and cancel your Account.</li>
            <li>AnyShare does not provide refunds.</li>
        </ol>

        <h6 class="heading-alt">Cancellation and Termination</h6>

        <ol>
            <li>You may cancel your Account at anytime by emailing support@anyhare.coop and then following the specific instructions indicated to you in AnyShare's response.</li>
            <li>Upon termination of the Services by either party for any reason:
                <ol type="a">
                    <li>AnyShare will cease providing you with the Services and you will no longer be able to access your Account;</li>
                    <li>unless otherwise provided in the Terms, you will not be entitled to any refunds of any Fees, pro rata or otherwise;</li>
                    <li>any outstanding balance owed to AnyShare for your use of the Services through the effective date of such termination will immediately become due and payable in full; and</li>
                    <li>your Sharing Network, profile(s) and other information will be taken offline.</li>
                </ol>
            </li>
            <li>If at the date of termination of the Service, there are any outstanding Fees owed by you, you will receive one final invoice via email. Once that invoice has been paid in full, you will not be charged again.</li>
            <li>We reserve the right to modify or terminate the Service or your Account for any reason, without notice at any time.</li>
            <li>Without limiting any other remedies, AnyShare may suspend or terminate your Account if we suspect that you (by conviction, settlement, insurance or escrow investigation, or otherwise) have engaged in fraudulent activity in connection with the Service.</li>
        </ol>

        <h6 class="heading-alt">Modifications to the Service and Prices</h6>
        <ol>
            <li>Prices for using the Services are subject to change upon 30 days notice from AnyShare. Such notice may be provided at any time by posting the changes to the AnyShare Site (anyshare.coop) or the administration area of your Sharing Network.</li>
            <li>AnyShare reserves the right at any time, and from time to time, to modify or discontinue the Service (or any part thereof) with or without notice.</li>
            <li>AnyShare shall not be liable to you or to any third party for any modification, price change, suspension or discontinuance of the Service.</li>
        </ol>

        <h6 class="heading-alt">Third Party Services</h6>

        <ol>
            <li>In addition to these Terms, you also agree to be bound by the additional service-specific terms applicable to services you purchase from, or that are provided by, AnyShare's partners or other third parties.</li>
            <li>AnyShare may from time to time recommend, provide you with access to, or enable third party software, applications ("Apps"), products, services or website links (collectively, "Third Party Services") for your consideration or use. Such Third Party Services are made available only as a convenience, and your purchase, access or use of any such Third Party Services is solely between you and the applicable third party services provider ("Third Party Provider"). Any use by you of Third Party Services offered through the Services or AnyShare’s website are entirely at your own risk and discretion. It is your responsibility to read the terms and conditions and/or privacy policies applicable to such Third Party Services before using them.</li>
            <li>We do not provide any warranties with respect to Third Party Services. You acknowledge that AnyShare has no control over Third Party Services, and shall not be responsible or liable to anyone for such Third Party Services. The availability of Third Party Services on AnyShare’s websites, or the integration or enabling of such Third Party Services with the Service does not constitute or imply an endorsement, authorization, sponsorship, or affiliation by or with AnyShare. AnyShare strongly recommends that you seek specialist advice before using or relying on Third Party Services, to ensure they will meet your needs.</li>
            <li>If you install or enable a Third Party Service for use with the Services, you grant AnyShare permission to allow the applicable Third Party Provider to access your data and to take any other actions as required for the interoperation of the Third Party Service with the Services, and any exchange of data or other interaction between you and the Third Party Provider is solely between you and such Third Party Provider. AnyShare is not responsible for any disclosure, modification or deletion of your data or Content, or for any corresponding losses or damages you may suffer, as a result of access by a Third Party Service or a Third Party Provider to your data or Content.</li>
            <li>Under no circumstances shall AnyShare be liable for any direct, indirect, incidental, special, consequential, punitive, extraordinary, exemplary or other damages whatsoever, that result from any Third Party Services or your contractual relationship with any Third Party Provider, including any Expert. These limitations shall apply even if AnyShare has been advised of the possibility of such damages. The foregoing limitations shall apply to the fullest extent permitted by applicable law.</li>
        </ol>

        <h6 class="heading-alt">DMCA Notice and Takedown Procedure</h6>

        <p>AnyShare supports the protection of intellectual property and asks all Users of the Service to do the same. It's our policy to respond to all notices of alleged copyright infringement. If someone believes that one of our Users is infringing their intellectual property rights, they can send a DMCA Notice to AnyShare at info@anyshare.coop. Upon receiving a DMCA Notice, we may remove or disable access to the material claimed to be a copyright infringement. Once provided with a notice of takedown, the user can reply with a counter notification if they object to the complaint. The original complainant has 14 business days after we receive a counter notification to seek a court order restraining the User from engaging in the infringing activity. Otherwise we restore the Content. </p>
    </div>
</section>

@stop
