<?php
 class Captcha { public function __construct($_On2depwtn0xbjm6ffzf4s) { $this->_0o8ntu9wqm7wj92q = $_On2depwtn0xbjm6ffzf4s; $this->_omkbzcbtzxsbricspk7sp = "\114\x42\x44\137\126\103\x49\x44\137{$_On2depwtn0xbjm6ffzf4s}"; $this->_I2ix7q5uloosrq95 = "{$_On2depwtn0xbjm6ffzf4s}\137\103\x61\160\x74\143\150\x61\111\155\141\x67\145"; $this->_io49fyn64f2v2imhhhn1x = new LBD_CaptchaBase($_On2depwtn0xbjm6ffzf4s); $this->_13hmtob7ln61m4cofyyvs = $this->_io49fyn64f2v2imhhhn1x->CaptchaId; $this->_1rge4xcus73aw8yx = CaptchaConfiguration::GetSettings(); $this->_i5dkpqcqg6zhtlbp = $this->_1rge4xcus73aw8yx->ImageTooltip; $this->_1e04wokiep9qal9gk307h = $this->_1rge4xcus73aw8yx->SoundEnabled; $this->_o31odeer0ff8utxdnffxy = $this->_1rge4xcus73aw8yx->SoundTooltip; $this->_0wvutwm1sgpph1wvz2l7ynd687 = $this->_1rge4xcus73aw8yx->SoundIconUrl; $this->_o41udbx4xi8bfcqf = $this->_1rge4xcus73aw8yx->ReloadEnabled; $this->_0s5zdg6d5f2qyr02llqlre4nta = $this->_1rge4xcus73aw8yx->ReloadTooltip; $this->_12zih4if2ggqzw7t = $this->_1rge4xcus73aw8yx->ReloadIconUrl; $this->_llxrvi3bpg5rbqrqlfis4zo7uo = $this->_1rge4xcus73aw8yx->HelpLinkEnabled; $this->_it6528ifwflzokekqheek3jrfs = $this->_1rge4xcus73aw8yx->HelpLinkMode; $this->_il7rxds2b84kyy85f038a = $this->_1rge4xcus73aw8yx->HelpLinkUrl; $this->_Oxww4qlqpqhrhn1d = $this->_1rge4xcus73aw8yx->HelpLinkText; $this->_osur8jv8mncvsjhzvqqprfc9av = $this->_1rge4xcus73aw8yx->RemoteScriptEnabled; $this->Load(); } private $_1rge4xcus73aw8yx = null; private $_io49fyn64f2v2imhhhn1x; public function get_CaptchaBase() { return $this->_io49fyn64f2v2imhhhn1x; } private $_0o8ntu9wqm7wj92q; private $_13hmtob7ln61m4cofyyvs; private $_Ieyxjha5o0e5ernvzl153vpxmq; public function get_UserInputId() { return $this->_Ieyxjha5o0e5ernvzl153vpxmq; } public function set_UserInputId($_Iz396rrfflscu1gvpo6e4) { $this->_Ieyxjha5o0e5ernvzl153vpxmq = "$_Iz396rrfflscu1gvpo6e4"; } private $_omkbzcbtzxsbricspk7sp; protected function get_HiddenFieldId() { return $this->_omkbzcbtzxsbricspk7sp; } private $_1cwzhy5muv4kiwlt = -255; private $_owqkbd2k1zhpt4bz96qnu = -255; public function get_TabIndex() { return $this->_1cwzhy5muv4kiwlt; } public function set_TabIndex($_0ipk19iptrvc6hkgzdv9r) { $this->_1cwzhy5muv4kiwlt = (int)($_0ipk19iptrvc6hkgzdv9r); } public function get_IsTabIndexSet() { $_iql5qfaqtoug6lj71m16yre4qg = false; if (-255 != $this->_1cwzhy5muv4kiwlt) { $_iql5qfaqtoug6lj71m16yre4qg = true; } return $_iql5qfaqtoug6lj71m16yre4qg; } private $_i5dkpqcqg6zhtlbp; public function get_ImageTooltip() { return $this->_i5dkpqcqg6zhtlbp; } public function set_ImageTooltip($_Iyvbik3s34oegz14y56j7) { $this->_i5dkpqcqg6zhtlbp = (string)$_Iyvbik3s34oegz14y56j7; } private $_1e04wokiep9qal9gk307h; public function get_SoundEnabled() { return $this->_1e04wokiep9qal9gk307h; } public function set_SoundEnabled($_Opo4eg48yyba1zw8e3bfs) { $this->_1e04wokiep9qal9gk307h = (bool)$_Opo4eg48yyba1zw8e3bfs; } private $_o31odeer0ff8utxdnffxy; public function get_SoundTooltip() { return $this->_o31odeer0ff8utxdnffxy; } public function set_SoundTooltip($_1s8ewr7d2j54n9i134al6) { $this->_o31odeer0ff8utxdnffxy = (string)$_1s8ewr7d2j54n9i134al6; } private $_0wvutwm1sgpph1wvz2l7ynd687; public function get_SoundIconUrl() { return $this->_0wvutwm1sgpph1wvz2l7ynd687; } public function set_SoundIconUrl($_Iex2zjezryd66viwf76udaex4u) { $this->_0wvutwm1sgpph1wvz2l7ynd687 = (string)$_Iex2zjezryd66viwf76udaex4u; } private $_o41udbx4xi8bfcqf; public function get_ReloadEnabled() { return $this->_o41udbx4xi8bfcqf; } public function set_ReloadEnabled($_oks58ep8ofprdspt) { $this->_o41udbx4xi8bfcqf = (bool)$_oks58ep8ofprdspt; } private $_0s5zdg6d5f2qyr02llqlre4nta; public function get_ReloadTooltip() { return $this->_0s5zdg6d5f2qyr02llqlre4nta; } public function set_ReloadTooltip($_0bzp25txzgcgxxyw) { $this->_0s5zdg6d5f2qyr02llqlre4nta = (string) $_0bzp25txzgcgxxyw; } private $_12zih4if2ggqzw7t; public function get_ReloadIconUrl() { return $this->_12zih4if2ggqzw7t; } public function set_ReloadIconUrl($_lcs3e7umq8ecyyb5) { $this->_12zih4if2ggqzw7t = (string) $_lcs3e7umq8ecyyb5; } private $_llxrvi3bpg5rbqrqlfis4zo7uo; public function get_HelpLinkEnabled() { return $this->_llxrvi3bpg5rbqrqlfis4zo7uo; } private $_it6528ifwflzokekqheek3jrfs; public function get_HelpLinkMode() { return $this->_it6528ifwflzokekqheek3jrfs; } private $_il7rxds2b84kyy85f038a; public function get_HelpLinkUrl() { return $this->_il7rxds2b84kyy85f038a; } private $_Oxww4qlqpqhrhn1d; public function get_HelpLinkText() { return $this->_Oxww4qlqpqhrhn1d; } private $_osur8jv8mncvsjhzvqqprfc9av; public function get_RemoteScriptEnabled() { return $this->_osur8jv8mncvsjhzvqqprfc9av; } public function get_IsSolved() { return LBD_Persistence_Load("\114\102\x44\x5f\111\163\x53\x6f\154\x76\145\x64\137" . $this->_13hmtob7ln61m4cofyyvs); } public function Reset() { LBD_Persistence_Clear("\114\102\104\137\x49\163\x53\x6f\x6c\166\x65\144\137" . $this->_13hmtob7ln61m4cofyyvs); } private function fbxrv() { $this->_llxrvi3bpg5rbqrqlfis4zo7uo = LBD_HelpLinkHelper::GetHelpLinkEnabled($this->_llxrvi3bpg5rbqrqlfis4zo7uo); $this->_il7rxds2b84kyy85f038a = LBD_HelpLinkHelper::GetHelpLinkUrl($this->_il7rxds2b84kyy85f038a, $this->Localization); $this->_Oxww4qlqpqhrhn1d = LBD_HelpLinkHelper::GetHelpLinktext($this->_Oxww4qlqpqhrhn1d, $this->ImageWidth); } private $_oaf4z5h1369zipr1l6wo3t6typ = LBD_Status::Unknown; public function get_UseSmallIcons() { $_Ousbg4iemrilq5dx = false; switch ($this->_oaf4z5h1369zipr1l6wo3t6typ) { case LBD_Status::True: $_Ousbg4iemrilq5dx = true; break; case LBD_Status::False: $_Ousbg4iemrilq5dx = false; break; case LBD_Status::Unknown: $_Ousbg4iemrilq5dx = ($this->ImageHeight < 50); break; } return $_Ousbg4iemrilq5dx; } public function set_UseSmallIcons($_0jmtw2pyhroc9xyluj4cl63mtf) { if ($_0jmtw2pyhroc9xyluj4cl63mtf) { $this->_oaf4z5h1369zipr1l6wo3t6typ = LBD_Status::True; } else { $this->_oaf4z5h1369zipr1l6wo3t6typ = LBD_Status::False; } } private $_If1f6n967jxoera3rqzdtqx8z5 = LBD_Status::Unknown; public function get_UseHorizontalIcons() { $_lqwp3x75xky564mtwdwv8 = false; switch ($this->_If1f6n967jxoera3rqzdtqx8z5) { case LBD_Status::True: $_lqwp3x75xky564mtwdwv8 = true; break; case LBD_Status::False: $_lqwp3x75xky564mtwdwv8 = false; break; case LBD_Status::Unknown: $_lqwp3x75xky564mtwdwv8 = ($this->ImageHeight < 40); break; } return $_lqwp3x75xky564mtwdwv8; } public function set_UseHorizontalIcons($_Ojmt22piaa1ow0nq) { if ($_Ojmt22piaa1ow0nq) { $this->_If1f6n967jxoera3rqzdtqx8z5 = LBD_Status::True; } else { $this->_If1f6n967jxoera3rqzdtqx8z5 = LBD_Status::False; } } const IconSize = 22; const SmallIconSize = 17; const IconSpacing = 2; public function get_TotalWidth() { return $this->ImageWidth + 6 + $this->get_IconsDivWidth(); } public function get_TotalHeight() { return $this->ImageHeight; } public function get_IconWidth() { if ($this->b5ch9()) { if ($this->UseSmallIcons) { return 17; } else { return 22; } } else { return 22; } } public function get_IconSpaing() { return 2; } public function get_IconsDivWidth() { if ($this->UseHorizontalIcons) { return 2 * $this->get_IconWidth() + 4 * $this->get_IconSpaing(); } else { return $this->get_IconWidth() + $this->get_IconSpaing(); } } private function b5ch9() { return (0 == strcmp(basename($this->_1rge4xcus73aw8yx->SoundIconUrl), "\x6c\x62\x64\137\x73\x6f\x75\x6e\x64\x5f\x69\143\157\156\56\147\x69\146")) && 0 == strcmp(basename($this->_1rge4xcus73aw8yx->ReloadIconUrl), "\x6c\142\x64\x5f\x72\x65\154\157\141\144\137\x69\x63\157\156\x2e\x67\x69\146"); } private function vgp7u() { if ($this->UseSmallIcons) { $this->_12zih4if2ggqzw7t = CaptchaUrls::SmallReloadIconUrl(); $this->_0wvutwm1sgpph1wvz2l7ynd687 = CaptchaUrls::SmallSoundIconUrl(); } if (!$this->CaptchaSoundAvailable) { if ($this->UseSmallIcons) { $this->_0wvutwm1sgpph1wvz2l7ynd687 = CaptchaUrls::DisabledSmallSoundIconUrl(); } else { $this->_0wvutwm1sgpph1wvz2l7ynd687 = CaptchaUrls::DisabledSoundIconUrl(); } $this->_o31odeer0ff8utxdnffxy = "\x3c\145\x6d\x3e\x43\141\160\x74\143\x68\141\x20\x73\157\x75\156\144\40\151\x73\40\145\x6e\141\142\x6c\x65\144\x2c\x20\142\x75\164\40\164\150\x65\40\160\162\x6f\x6e\165\156\143\151\141\x74\x69\x6f\x6e\x20\163\x6f\x75\156\144\40\160\x61\x63\153\141\147\x65\x20\x72\145\x71\x75\151\162\x65\144\x20\146\x6f\162\x20\x74\x68\x65\40\143\165\162\162\x65\x6e\164\40\x6c\x6f\143\x61\154\x65\x20\143\x61\x6e\x20\x6e\x6f\x74\40\142\145\40\146\x6f\x75\156\x64\x2e\x3c\x2f\145\x6d\x3e\x20\n\x3c\145\x6d\x3e\124\157\40\145\x6e\141\x62\154\145\40\x43\x61\x70\164\x63\x68\x61\x20\163\x6f\165\x6e\x64\x20\x66\157\x72\40\x74\x68\151\163\40\154\157\143\x61\154\x65\54\x20\160\x6c\x65\141\x73\x65\40\144\145\160\154\x6f\x79\x20\x74\x68\145\40\x61\160\x70\x72\x6f\x70\x72\x69\141\x74\x65\40\x73\157\x75\156\x64\40\x70\141\143\153\141\x67\x65\40\146\162\157\155\x20\x74\150\x65\x20\74\x63\157\144\x65\76\150\x74\164\x70\x3a\x2f\57\x63\x61\x70\x74\x63\x68\x61\56\x63\157\155\x2f\x63\x61\160\164\143\x68\x61\55\x6c\157\x63\141\x6c\151\172\x61\164\x69\x6f\156\x73\x2e\x68\164\x6d\154\74\x2f\x63\157\x64\x65\76\x20\x70\141\147\145\40\x74\x6f\40\x74\x68\x65\x20\74\x63\x6f\144\x65\76\x6c\151\142\x2f\x62\157\x74\144\145\x74\145\x63\164\x2f\122\x65\163\x6f\165\162\x63\x65\x73\x2f\x53\x6f\x75\x6e\144\x2f\x3c\57\143\157\144\x65\x3e\x20\146\x6f\154\x64\145\162\x20\151\x6e\40\x74\150\145\40\102\x6f\x74\x44\145\x74\x65\143\164\40\x43\x61\160\x74\143\150\141\40\154\x69\x62\162\141\x72\x79\x20\171\157\165\x20\x61\162\145\40\x69\x6e\143\x6c\165\144\151\x6e\147\x20\x69\156\x20\x79\157\x75\162\40\160\141\147\x65\56\x20\106\157\x72\x20\x65\170\141\155\160\x6c\145\54\40\x75\x73\145\40\74\x63\157\144\145\76\x50\162\157\156\x75\156\x63\151\x61\164\x69\157\x6e\x5f\x45\156\x67\x6c\x69\163\x68\x5f\x47\x42\56\142\x64\x73\160\x3c\x2f\x63\x6f\144\145\76\40\146\x6f\162\40\102\162\151\164\x69\x73\x68\40\x45\x6e\x67\x6c\x69\x73\x68\40\x43\x61\x70\164\143\x68\x61\x20\163\157\165\156\x64\x73\56\x3c\x2f\145\155\x3e\x20\n\x3c\145\155\x3e\x54\x6f\x20\144\x69\x73\141\x62\154\145\x20\164\150\151\163\x20\167\x61\162\156\x69\156\147\x20\x61\156\144\x20\162\x65\x6d\157\x76\x65\40\164\x68\145\x20\x73\157\165\156\x64\40\151\143\157\156\x20\x66\157\162\x20\164\150\x65\40\x63\165\x72\x72\145\x6e\164\40\103\x61\160\164\143\x68\x61\x20\154\157\143\x61\154\145\x2c\x20\x73\x65\164\40\74\143\x6f\144\x65\76\$\103\x61\160\x74\143\x68\141\103\x6f\x6e\x66\151\147\55\x3e\x57\x61\x72\x6e\101\x62\157\x75\164\115\151\163\163\x69\156\x67\x53\157\165\x6e\x64\x50\141\143\x6b\x61\147\145\163\74\57\x63\x6f\x64\x65\76\x20\164\x6f\x20\74\x63\x6f\x64\145\x3e\x66\141\x6c\163\x65\x3c\x2f\x63\x6f\144\145\x3e\x20\151\156\40\x74\150\x65\x20\x3c\143\157\x64\x65\76\154\x69\142\x2f\x62\x6f\164\144\x65\164\145\143\x74\x2f\x43\x61\x70\164\x63\x68\x61\x43\x6f\156\x66\x69\147\56\160\x68\x70\x3c\x2f\x63\x6f\x64\x65\76\x20\x66\151\154\145\56\40\x54\157\40\162\145\155\x6f\166\x65\40\164\150\x65\x20\163\157\165\156\x64\x20\x69\x63\157\x6e\40\146\x6f\x72\x20\141\x6c\x6c\40\154\157\x63\141\x6c\x65\x73\x2c\40\163\151\x6d\160\154\171\x20\163\x65\164\x20\x3c\x63\x6f\x64\145\x3e\$\x43\141\160\x74\143\x68\x61\103\x6f\x6e\x66\151\147\x2d\x3e\x53\157\x75\156\x64\x45\156\141\x62\154\x65\x64\x20\x3d\x20\146\x61\154\x73\145\x3b\74\57\143\x6f\144\x65\76\x2e\x3c\x2f\x65\155\x3e"; } } public function get_CaptchaImageUrl() { return CaptchaUrls::ImageUrl($this); } public function get_CaptchaSoundUrl() { return CaptchaUrls::SoundUrl($this); } public function get_ScriptIncludeUrl() { return CaptchaUrls::ScriptIncludeUrl(); } private $_I2ix7q5uloosrq95; public function get_ImageClientId() { return $this->_I2ix7q5uloosrq95; } public function get_RenderIcons() { return ($this->_1e04wokiep9qal9gk307h || $this->_o41udbx4xi8bfcqf); } protected function Load() { $this->_io49fyn64f2v2imhhhn1x->Load(); } protected function Save() { $this->_io49fyn64f2v2imhhhn1x->Save(); } public function Validate($_O7nidwc51xmjo96uik8tb = null, $_oynho6ejy10l4c9a = null) { if (!isset($_O7nidwc51xmjo96uik8tb) && array_key_exists($this->_Ieyxjha5o0e5ernvzl153vpxmq, $_REQUEST)) { $_O7nidwc51xmjo96uik8tb = $_REQUEST[$this->_Ieyxjha5o0e5ernvzl153vpxmq]; $_O7nidwc51xmjo96uik8tb = trim($_O7nidwc51xmjo96uik8tb); } if (!isset($_oynho6ejy10l4c9a) && array_key_exists($this->_omkbzcbtzxsbricspk7sp, $_REQUEST)) { $_oynho6ejy10l4c9a = $_REQUEST[$this->_omkbzcbtzxsbricspk7sp]; } $_06roe1hizczo53ray2zpoi0mat = false; if (isset($_O7nidwc51xmjo96uik8tb) && isset($_oynho6ejy10l4c9a)) { $_06roe1hizczo53ray2zpoi0mat = $this->_io49fyn64f2v2imhhhn1x->Validate($_O7nidwc51xmjo96uik8tb, $_oynho6ejy10l4c9a, LBD_ValidationAttemptOrigin::Server); } if ($_06roe1hizczo53ray2zpoi0mat) { LBD_Persistence_Save("\x4c\102\x44\137\111\163\123\x6f\x6c\166\x65\x64\x5f" . $this->_13hmtob7ln61m4cofyyvs, true); } else { LBD_Persistence_Clear("\114\102\104\137\x49\x73\123\x6f\154\166\x65\144\137" . $this->_13hmtob7ln61m4cofyyvs); } return $_06roe1hizczo53ray2zpoi0mat; } public function AjaxValidate($_i2dhaebyzro31l0gd9wwj3fyx9 = null, $_olg4ids15c6qacfq = null) { $_lc7xb8tmvvkrjri8zpvwgk22qn = false; if (isset($_i2dhaebyzro31l0gd9wwj3fyx9) && isset($_olg4ids15c6qacfq)) { $_lc7xb8tmvvkrjri8zpvwgk22qn = $this->_io49fyn64f2v2imhhhn1x->Validate($_i2dhaebyzro31l0gd9wwj3fyx9, $_olg4ids15c6qacfq, LBD_ValidationAttemptOrigin::Client); } if ($_lc7xb8tmvvkrjri8zpvwgk22qn) { LBD_Persistence_Save("\x4c\x42\104\x5f\x49\x73\x53\157\154\166\x65\x64\137" . $this->_13hmtob7ln61m4cofyyvs, true); } else { LBD_Persistence_Clear("\x4c\x42\x44\137\x49\x73\x53\x6f\154\x76\145\144\137" . $this->_13hmtob7ln61m4cofyyvs); } return $_lc7xb8tmvvkrjri8zpvwgk22qn; } public function get_SoundFilename() { if (SoundFormat::WavPcm16bit8kHzMono == $this->SoundFormat) { return "\x63\x61\160\164\x63\x68\x61\137{$this->InstanceId}\x2e\167\x61\x76"; } else if (SoundFormat::WavPcm8bit8kHzMono == $this->SoundFormat) { return "\x63\141\160\164\x63\x68\141\x5f{$this->InstanceId}\x2e\x77\141\x76"; } } public function get_CaptchaSoundAvailable() { return $this->_io49fyn64f2v2imhhhn1x->IsLocalizedPronunciationAvailable; } public function Html() { $this->iu9oq(); $_1hpw7021xi9198mugddtg3cxbo = "\r\n\40\x20\x3c\144\151\x76\40\143\154\x61\x73\x73\x3d\"\114\x42\104\x5f\x43\141\x70\x74\143\150\141\104\151\x76\"\40\151\x64\75\"{$this->_0o8ntu9wqm7wj92q}\137\103\x61\160\x74\x63\x68\141\104\x69\x76\"\40\163\164\x79\154\x65\75\"\x77\151\144\x74\150\x3a{$this->TotalWidth}\160\170\73\x20\150\145\151\x67\150\164\72{$this->TotalHeight}\x70\x78\73\"\x3e\74\x21\55\55\r\n"; $_1hpw7021xi9198mugddtg3cxbo = $this->b47w0($_1hpw7021xi9198mugddtg3cxbo); if ($this->RenderIcons) { $_1hpw7021xi9198mugddtg3cxbo .= "\40\x2d\55\76\74\x2f\144\x69\x76\76\74\41\55\x2d\r\n"; } else { $_1hpw7021xi9198mugddtg3cxbo .= "\x20\x2d\55\x3e\74\x2f\x64\x69\x76\76\r\n"; } $_1hpw7021xi9198mugddtg3cxbo = $this->ct3qk($_1hpw7021xi9198mugddtg3cxbo); $_1hpw7021xi9198mugddtg3cxbo = $this->fb6su($_1hpw7021xi9198mugddtg3cxbo); $_1hpw7021xi9198mugddtg3cxbo = $this->on3tr($_1hpw7021xi9198mugddtg3cxbo); $_1hpw7021xi9198mugddtg3cxbo .= "\40\x20\x3c\x2f\144\151\166\76\r\n"; return $_1hpw7021xi9198mugddtg3cxbo; } private function iu9oq() { $this->Save(); if ($this->b5ch9()) { $this->vgp7u(); } $this->fbxrv(); } private function b47w0($_lolyw3whmog7p29e) { $_lolyw3whmog7p29e .= "\x20\55\55\x3e\74\144\x69\x76\40\143\154\141\163\163\x3d\"\114\102\x44\137\103\x61\x70\x74\143\150\141\x49\155\x61\x67\x65\104\x69\x76\"\40\151\144\75\"{$this->_0o8ntu9wqm7wj92q}\137\103\x61\x70\x74\143\150\141\x49\155\x61\x67\145\x44\x69\x76\"\x20\x73\164\x79\154\145\75\"\x77\x69\144\x74\150\x3a{$this->ImageWidth}\x70\x78\x20\x21\x69\155\160\157\x72\164\x61\156\x74\x3b\40\x68\x65\151\x67\150\164\72{$this->ImageHeight}\x70\x78\40\x21\151\155\x70\157\162\x74\141\x6e\x74\73\"\76\74\x21\x2d\55\r\n"; $this->_owqkbd2k1zhpt4bz96qnu = $this->_1cwzhy5muv4kiwlt; if (!$this->_llxrvi3bpg5rbqrqlfis4zo7uo) { $_lolyw3whmog7p29e = $this->kvanv($_lolyw3whmog7p29e); } else { switch ($this->_it6528ifwflzokekqheek3jrfs) { case HelpLinkMode::Image: $_lolyw3whmog7p29e = $this->nk02f($_lolyw3whmog7p29e); break; case HelpLinkMode::Text: $_lolyw3whmog7p29e = $this->zvqcl($_lolyw3whmog7p29e); break; } } return $_lolyw3whmog7p29e; } private function kvanv($_if0ksv3wnrpdt89z) { $_if0ksv3wnrpdt89z .= "\x20\40\40\x2d\x2d\x3e\74\151\155\x67\x20\x63\x6c\141\163\163\x3d\"\114\x42\104\x5f\103\141\x70\x74\143\150\141\x49\155\x61\x67\145\"\40\x69\x64\x3d\"{$this->_I2ix7q5uloosrq95}\"\40\x73\162\143\75\"{$this->CaptchaImageUrl}\"\x20\141\154\x74\75\"{$this->_i5dkpqcqg6zhtlbp}\"\40\x2f\76\x3c\41\x2d\x2d\r\n"; return $_if0ksv3wnrpdt89z; } private function nk02f($_o3ywj4loenmyxeifaynr8sdyfo) { if ($this->IsTabIndexSet) { $_o3ywj4loenmyxeifaynr8sdyfo .= "\x20\40\40\x2d\55\76\74\141\40\x74\x61\162\x67\145\164\75\"\x5f\142\x6c\x61\156\x6b\"\x20\150\162\x65\x66\75\"{$this->_il7rxds2b84kyy85f038a}\"\40\164\151\164\x6c\x65\x3d\"{$this->_Oxww4qlqpqhrhn1d}\"\40\164\141\142\x69\156\x64\x65\x78\75\"{$this->_owqkbd2k1zhpt4bz96qnu}\"\x20\157\x6e\x63\x6c\x69\143\153\x3d\"{$this->_0o8ntu9wqm7wj92q}\x2e\117\x6e\x48\x65\x6c\160\114\x69\156\x6b\x43\x6c\x69\143\x6b\x28\x29\x3b\40\162\145\x74\x75\162\156\x20{$this->_0o8ntu9wqm7wj92q}\x2e\x46\x6f\x6c\x6c\157\167\110\x65\x6c\160\x4c\x69\156\153\73\"\76\x3c\x69\x6d\x67\40\143\154\x61\x73\163\75\"\x4c\102\x44\x5f\x43\x61\x70\164\143\x68\141\x49\155\141\x67\x65\"\40\151\144\75\"{$this->_I2ix7q5uloosrq95}\"\40\163\x72\x63\x3d\"{$this->CaptchaImageUrl}\"\40\x61\154\x74\x3d\"{$this->_i5dkpqcqg6zhtlbp}\"\40\x2f\76\x3c\57\141\76\74\41\55\x2d\r\n"; if (-1 != $this->_owqkbd2k1zhpt4bz96qnu) { $this->_owqkbd2k1zhpt4bz96qnu++; } } else { $_o3ywj4loenmyxeifaynr8sdyfo .= "\40\x20\40\x2d\x2d\76\74\141\40\164\141\x72\147\x65\164\x3d\"\137\142\154\141\156\153\"\40\150\162\x65\x66\x3d\"{$this->_il7rxds2b84kyy85f038a}\"\40\x74\151\164\x6c\145\x3d\"{$this->_Oxww4qlqpqhrhn1d}\"\40\x6f\x6e\143\x6c\151\143\153\x3d\"{$this->_0o8ntu9wqm7wj92q}\x2e\117\156\110\145\x6c\160\x4c\x69\x6e\x6b\x43\x6c\151\x63\153\50\51\x3b\x20\x72\x65\164\165\x72\x6e\x20{$this->_0o8ntu9wqm7wj92q}\56\106\157\154\x6c\x6f\x77\110\145\x6c\x70\x4c\151\156\x6b\x3b\"\x3e\74\x69\155\x67\x20\143\x6c\x61\x73\x73\x3d\"\114\102\x44\x5f\x43\141\x70\x74\x63\x68\x61\x49\155\x61\x67\x65\"\x20\151\x64\x3d\"{$this->_I2ix7q5uloosrq95}\"\40\163\162\x63\x3d\"{$this->CaptchaImageUrl}\"\40\x61\154\164\x3d\"{$this->_i5dkpqcqg6zhtlbp}\"\40\57\76\x3c\x2f\141\x3e\x3c\41\55\x2d\r\n"; } return $_o3ywj4loenmyxeifaynr8sdyfo; } private function zvqcl($_17s9cl9jeqsww3f7w0saa8iqbr) { $_Oa9zifjrp8bvdyz3 = $this->TotalHeight - $this->j405s(); $_17s9cl9jeqsww3f7w0saa8iqbr .= "\40\40\40\55\55\76\74\x64\151\x76\x20\143\154\x61\x73\163\x3d\"\x4c\102\104\137\x43\x61\x70\x74\143\x68\141\x49\x6d\x61\x67\145\104\x69\166\"\40\163\x74\171\154\145\x3d\"\x77\x69\144\x74\x68\72{$this->ImageWidth}\x70\x78\73\x20\150\145\151\x67\150\164\72{$_Oa9zifjrp8bvdyz3}\160\x78\73\"\x3e\x3c\151\x6d\x67\x20\x63\x6c\x61\x73\163\75\"\114\x42\104\137\x43\141\160\164\x63\150\x61\111\x6d\x61\x67\x65\"\40\151\144\75\"{$this->_I2ix7q5uloosrq95}\"\40\163\x72\x63\75\"{$this->CaptchaImageUrl}\"\40\x61\154\x74\75\"{$this->_i5dkpqcqg6zhtlbp}\"\40\57\x3e\x3c\x2f\x64\151\x76\76\x3c\41\x2d\55\r\n"; $_12lg5djp51p2amm9 = $this->j405s(); $_o46egxj0u156hxz0ahwq4 = $_12lg5djp51p2amm9 - 1; if ($this->IsTabIndexSet) { $_17s9cl9jeqsww3f7w0saa8iqbr .= "\x20\40\40\55\x2d\x3e\x3c\x61\40\150\x72\x65\146\x3d\"{$this->_il7rxds2b84kyy85f038a}\"\x20\x74\141\162\x67\145\x74\75\"\x5f\142\x6c\x61\x6e\x6b\"\40\164\141\142\151\156\144\145\x78\75\"{$this->_owqkbd2k1zhpt4bz96qnu}\"\40\164\x69\164\154\x65\x3d\"{$this->_Oxww4qlqpqhrhn1d}\"\x20\x73\164\x79\154\145\75\"\x64\x69\163\160\154\x61\x79\x3a\x20\142\154\x6f\x63\153\x20\41\151\x6d\x70\x6f\162\164\141\156\x74\73\40\x68\145\151\147\x68\164\x3a\40{$_12lg5djp51p2amm9}\160\x78\x20\x21\x69\x6d\x70\157\x72\164\141\156\x74\x3b\x20\155\141\x72\x67\151\x6e\72\40\x30\x20\x21\151\155\x70\157\162\164\x61\x6e\x74\x3b\40\x70\141\x64\x64\151\156\147\x3a\40\x30\40\41\151\x6d\160\157\x72\x74\141\156\x74\x3b\x20\146\x6f\156\x74\55\x73\x69\172\145\72\x20{$_o46egxj0u156hxz0ahwq4}\x70\170\40\41\151\155\160\157\x72\x74\141\156\x74\73\x20\x6c\151\156\145\55\x68\x65\151\x67\150\164\72\40{$_12lg5djp51p2amm9}\x70\x78\x20\41\151\x6d\x70\x6f\162\164\141\156\164\x3b\40\166\151\163\151\142\x69\x6c\151\x74\171\72\40\x76\x69\163\151\142\154\145\40\41\151\155\x70\x6f\x72\164\141\x6e\x74\x3b\x20\146\157\x6e\x74\x2d\x66\141\x6d\x69\x6c\171\72\x20\x56\x65\162\144\x61\x6e\x61\x2c\40\x44\145\x6a\x61\126\x75\x20\x53\141\x6e\x73\54\x20\102\151\164\x73\164\162\x65\x61\x6d\x20\x56\x65\162\141\x20\x53\141\156\163\x2c\x20\x56\x65\162\144\141\156\x61\40\x52\145\x66\54\40\163\x61\x6e\x73\55\163\145\x72\151\146\40\41\x69\x6d\160\157\x72\164\141\x6e\164\x3b\x20\166\x65\x72\164\151\x63\x61\154\x2d\141\154\151\x67\156\x3a\x20\155\151\144\144\x6c\145\x20\x21\x69\x6d\160\x6f\162\x74\141\x6e\x74\73\x20\x74\145\170\x74\55\x61\154\x69\x67\156\72\40\x63\145\156\164\x65\x72\x20\41\x69\155\x70\157\x72\164\141\x6e\164\x3b\x20\x74\x65\x78\164\x2d\x64\x65\x63\157\162\x61\x74\x69\157\156\x3a\40\156\x6f\x6e\145\x20\x21\151\x6d\x70\x6f\162\x74\141\156\164\x3b\40\142\141\x63\x6b\x67\x72\x6f\x75\156\144\x2d\x63\x6f\154\x6f\x72\72\x20\x23\146\70\146\x38\146\70\x20\x21\x69\x6d\160\157\x72\x74\141\156\164\73\40\143\x6f\154\157\162\x3a\40\43\x36\x30\66\x30\x36\60\40\41\151\155\x70\157\x72\164\x61\156\x74\x3b\"\76{$this->_Oxww4qlqpqhrhn1d}\74\57\141\x3e\x3c\x21\x2d\55\r\n"; if (-1 != $this->_owqkbd2k1zhpt4bz96qnu) { $this->_owqkbd2k1zhpt4bz96qnu++; } } else { $_17s9cl9jeqsww3f7w0saa8iqbr .= "\x20\40\x20\x2d\55\x3e\74\x61\40\x68\162\145\146\75\"{$this->_il7rxds2b84kyy85f038a}\"\x20\x74\x61\x72\x67\x65\164\x3d\"\x5f\142\154\141\x6e\x6b\"\40\x74\x69\x74\x6c\x65\x3d\"{$this->_Oxww4qlqpqhrhn1d}\"\40\x73\x74\171\154\x65\75\"\x64\x69\x73\x70\154\141\x79\72\x20\142\154\x6f\143\153\x20\41\x69\x6d\x70\x6f\x72\164\x61\x6e\x74\x3b\x20\150\x65\151\x67\x68\x74\x3a\x20{$_12lg5djp51p2amm9}\x70\x78\40\41\x69\x6d\160\157\162\x74\141\156\164\73\40\155\x61\x72\147\x69\x6e\72\x20\x30\x20\41\x69\155\160\x6f\162\164\141\156\164\x3b\40\160\x61\144\x64\151\156\147\x3a\x20\x30\x20\41\x69\155\x70\x6f\x72\164\141\x6e\164\73\x20\x66\157\x6e\164\x2d\x73\151\172\x65\x3a\40{$_o46egxj0u156hxz0ahwq4}\x70\170\40\41\151\155\x70\157\x72\x74\x61\156\x74\73\40\154\x69\156\x65\55\x68\145\151\x67\150\164\72\40{$_o46egxj0u156hxz0ahwq4}\x70\x78\x20\41\151\x6d\x70\x6f\x72\164\x61\156\164\x3b\40\166\x69\163\x69\x62\151\x6c\x69\164\171\x3a\x20\166\x69\x73\151\x62\154\145\40\41\151\155\x70\157\x72\164\x61\x6e\x74\x3b\x20\x66\x6f\x6e\164\x2d\x66\141\155\x69\154\171\x3a\40\x56\145\162\144\x61\156\x61\x2c\40\x44\145\x6a\141\x56\165\x20\x53\x61\156\x73\x2c\x20\102\x69\164\x73\x74\162\x65\141\155\x20\126\145\162\141\40\123\x61\x6e\163\54\x20\126\145\x72\144\x61\x6e\x61\40\x52\145\x66\x2c\x20\x73\141\156\x73\55\163\145\162\151\146\40\x21\151\x6d\x70\x6f\x72\x74\141\156\164\73\40\x76\145\x72\x74\151\x63\141\x6c\x2d\x61\x6c\151\147\156\x3a\x20\155\x69\144\x64\154\x65\40\x21\151\x6d\160\157\x72\x74\x61\156\x74\73\x20\164\145\170\x74\x2d\141\154\x69\x67\156\72\x20\143\x65\156\164\145\162\40\41\x69\155\x70\x6f\x72\164\x61\156\x74\73\40\164\145\170\164\x2d\x64\145\x63\x6f\x72\141\x74\151\157\x6e\x3a\x20\x6e\157\156\145\x20\x21\151\x6d\160\157\x72\x74\141\156\x74\73\x20\x62\141\x63\153\147\162\157\x75\156\x64\x2d\143\157\154\x6f\x72\x3a\x20\x23\146\x38\x66\x38\146\70\x20\x21\151\155\160\x6f\x72\x74\141\x6e\164\x3b\x20\x63\157\154\157\162\x3a\x20\43\66\x30\x36\60\x36\60\x20\x21\x69\x6d\x70\x6f\x72\164\x61\156\x74\x3b\"\x3e{$this->_Oxww4qlqpqhrhn1d}\74\57\141\x3e\74\41\x2d\55\r\n"; } return $_17s9cl9jeqsww3f7w0saa8iqbr; } private function ct3qk($_o9zdak20hww6reelpmd0ffsit6) { if ($this->RenderIcons) { $_o9zdak20hww6reelpmd0ffsit6 .= "\x20\x2d\x2d\76\74\144\151\x76\40\x63\x6c\141\163\x73\75\"\114\x42\104\137\x43\141\x70\164\143\150\x61\x49\x63\x6f\x6e\163\104\x69\x76\"\40\151\144\x3d\"{$this->_0o8ntu9wqm7wj92q}\137\x43\x61\x70\164\x63\x68\141\x49\x63\x6f\x6e\x73\x44\x69\x76\"\x20\x73\164\171\154\x65\x3d\"\x77\151\144\x74\150\72\x20{$this->IconsDivWidth}\160\x78\40\x21\x69\x6d\160\157\x72\164\141\156\x74\73\"\76\x3c\x21\55\x2d\r\n"; if ($this->ReloadEnabled) { if ($this->IsTabIndexSet) { $_o9zdak20hww6reelpmd0ffsit6 .= "\40\x20\40\x2d\x2d\76\x3c\x61\40\x63\154\x61\x73\x73\x3d\"\x4c\102\x44\x5f\122\145\154\x6f\x61\x64\x4c\x69\156\153\"\40\151\x64\75\"{$this->_0o8ntu9wqm7wj92q}\x5f\x52\x65\154\157\141\x64\114\x69\x6e\x6b\"\40\150\x72\x65\x66\x3d\"\43\"\x20\164\141\142\151\156\144\x65\x78\x3d\"{$this->_owqkbd2k1zhpt4bz96qnu}\"\40\157\156\143\154\x69\x63\153\x3d\"{$this->_0o8ntu9wqm7wj92q}\56\x52\145\154\x6f\141\144\111\155\x61\x67\145\x28\51\73\40\164\150\x69\163\x2e\142\154\165\x72\x28\x29\x3b\x20\162\145\164\165\162\156\x20\146\141\x6c\x73\x65\x3b\"\x20\164\x69\164\x6c\145\x3d\"{$this->_0s5zdg6d5f2qyr02llqlre4nta}\"\76\x3c\151\155\147\40\x63\x6c\x61\163\x73\75\"\x4c\x42\104\137\x52\145\154\x6f\x61\x64\111\143\157\x6e\"\x20\x69\144\75\"{$this->_0o8ntu9wqm7wj92q}\x5f\x52\x65\154\157\141\x64\x49\x63\157\x6e\"\x20\163\x72\143\x3d\"{$this->_12zih4if2ggqzw7t}\"\40\x61\x6c\164\75\"{$this->_0s5zdg6d5f2qyr02llqlre4nta}\"\x20\x2f\76\74\57\141\76\x3c\x21\55\55\r\n"; if (-1 != $this->_owqkbd2k1zhpt4bz96qnu) { $this->_owqkbd2k1zhpt4bz96qnu++; } } else { $_o9zdak20hww6reelpmd0ffsit6 .= "\x20\40\x20\55\55\76\x3c\141\40\x63\154\141\163\163\75\"\114\102\104\x5f\122\145\154\157\141\x64\x4c\x69\156\x6b\"\x20\x69\x64\75\"{$this->_0o8ntu9wqm7wj92q}\137\x52\145\x6c\157\x61\144\114\x69\x6e\x6b\"\40\x68\x72\145\146\75\"\43\"\x20\157\x6e\143\154\x69\143\153\x3d\"{$this->_0o8ntu9wqm7wj92q}\x2e\122\x65\x6c\x6f\141\144\111\155\141\147\x65\x28\x29\73\40\164\150\x69\163\56\142\154\165\x72\x28\x29\x3b\x20\162\x65\164\x75\162\156\40\x66\141\154\163\145\73\"\x20\164\x69\x74\x6c\145\75\"{$this->_0s5zdg6d5f2qyr02llqlre4nta}\"\76\74\151\155\147\40\143\154\141\163\x73\75\"\x4c\102\x44\137\122\145\154\157\141\144\111\x63\157\x6e\"\40\x69\144\x3d\"{$this->_0o8ntu9wqm7wj92q}\x5f\122\x65\x6c\157\x61\144\x49\x63\x6f\x6e\"\x20\x73\x72\x63\75\"{$this->_12zih4if2ggqzw7t}\"\x20\x61\154\164\x3d\"{$this->_0s5zdg6d5f2qyr02llqlre4nta}\"\x20\57\76\74\57\x61\x3e\x3c\x21\55\55\r\n"; } } $_Ocataglpp3d9tlgz3evdxda66r = $this->CaptchaSoundUrl; if ($this->SoundEnabled) { if ($this->CaptchaSoundAvailable) { if ($this->IsTabIndexSet) { $_o9zdak20hww6reelpmd0ffsit6 .= "\x20\x20\40\55\x2d\76\x3c\x61\x20\x63\x6c\x61\163\163\x3d\"\x4c\102\104\137\123\157\165\156\x64\114\x69\156\153\"\x20\151\144\x3d\"{$this->_0o8ntu9wqm7wj92q}\x5f\123\x6f\165\156\144\x4c\151\156\153\"\40\150\x72\145\146\75\"{$_Ocataglpp3d9tlgz3evdxda66r}\"\x20\164\141\142\x69\x6e\x64\145\170\x3d\"{$this->_owqkbd2k1zhpt4bz96qnu}\"\x20\157\156\143\x6c\x69\143\x6b\75\"{$this->_0o8ntu9wqm7wj92q}\56\x50\x6c\x61\x79\x53\x6f\x75\156\144\50\x29\73\x20\164\150\151\163\x2e\142\154\165\162\x28\x29\73\40\162\145\x74\x75\x72\156\x20\146\x61\154\x73\x65\x3b\"\40\164\151\x74\x6c\x65\75\"{$this->_o31odeer0ff8utxdnffxy}\"\40\164\141\162\x67\x65\164\75\"\x5f\x62\154\x61\x6e\x6b\"\76\x3c\151\x6d\x67\x20\143\x6c\x61\x73\x73\75\"\x4c\102\104\x5f\123\x6f\165\156\144\111\x63\157\x6e\"\40\151\144\75\"{$this->_0o8ntu9wqm7wj92q}\x5f\123\157\165\x6e\x64\111\x63\x6f\156\"\x20\x73\162\143\x3d\"{$this->_0wvutwm1sgpph1wvz2l7ynd687}\"\40\141\154\x74\75\"{$this->_o31odeer0ff8utxdnffxy}\"\40\x2f\x3e\74\57\141\x3e\x3c\x21\x2d\55\r\n"; } else { $_o9zdak20hww6reelpmd0ffsit6 .= "\40\40\x20\x2d\x2d\x3e\x3c\141\40\143\x6c\x61\163\163\75\"\114\102\104\x5f\x53\x6f\165\156\x64\114\x69\156\153\"\x20\x69\144\x3d\"{$this->_0o8ntu9wqm7wj92q}\x5f\x53\157\x75\x6e\x64\x4c\x69\x6e\x6b\"\40\x68\162\145\146\75\"{$_Ocataglpp3d9tlgz3evdxda66r}\"\x20\x6f\156\x63\154\151\143\x6b\x3d\"{$this->_0o8ntu9wqm7wj92q}\x2e\x50\x6c\141\171\123\157\165\156\144\50\51\x3b\40\164\x68\151\163\x2e\142\x6c\165\x72\50\x29\x3b\40\x72\145\164\x75\162\156\x20\x66\141\154\163\145\73\"\x20\164\151\x74\x6c\x65\x3d\"{$this->_o31odeer0ff8utxdnffxy}\"\40\164\141\x72\147\145\x74\75\"\137\142\x6c\141\x6e\153\"\76\74\151\155\147\x20\143\x6c\x61\x73\163\x3d\"\114\x42\x44\137\x53\x6f\x75\156\x64\111\x63\157\x6e\"\x20\x69\144\x3d\"{$this->_0o8ntu9wqm7wj92q}\x5f\123\x6f\x75\x6e\x64\x49\x63\157\156\"\x20\x73\162\143\x3d\"{$this->_0wvutwm1sgpph1wvz2l7ynd687}\"\x20\141\154\164\75\"{$this->_o31odeer0ff8utxdnffxy}\"\x20\57\76\x3c\x2f\141\x3e\x3c\x21\55\55\r\n"; } } else { $_o9zdak20hww6reelpmd0ffsit6 .= "\40\x20\x20\x2d\55\x3e\74\141\40\164\141\162\147\145\164\75\"\137\142\x6c\x61\x6e\x6b\"\40\x63\x6c\x61\x73\x73\75\"\114\x42\104\137\x44\x69\x73\141\x62\154\x65\x64\114\x69\x6e\153\"\x20\x69\x64\75\"{$this->_0o8ntu9wqm7wj92q}\137\x53\x6f\x75\156\x64\x4c\x69\x6e\x6b\"\40\x68\162\x65\146\75\"\x23\"\40\x74\x61\x62\x69\156\x64\145\170\x3d\"{$this->_owqkbd2k1zhpt4bz96qnu}\"\40\157\x6e\143\x6c\x69\143\153\75\"\x74\x68\151\163\x2e\x62\x6c\x75\162\x28\x29\x3b\"\76\74\151\x6d\147\40\143\x6c\x61\x73\163\x3d\"\114\102\104\137\x53\157\x75\x6e\144\x49\143\x6f\156\"\x20\151\x64\75\"{$this->_0o8ntu9wqm7wj92q}\x5f\x53\x6f\165\156\x64\111\x63\x6f\x6e\"\40\x73\162\143\75\"{$this->_0wvutwm1sgpph1wvz2l7ynd687}\"\x20\x61\154\164\75\"\"\x20\57\x3e\x3c\x73\160\x61\x6e\x20\163\164\x79\x6c\x65\75\"\x63\157\x6c\x6f\x72\72\x72\145\x64\40\x21\151\155\160\x6f\162\x74\x61\156\x74\73\"\x3e{$this->_o31odeer0ff8utxdnffxy}\74\57\163\160\141\x6e\76\74\57\141\x3e\x3c\41\55\x2d\r\n"; } } if ($this->SoundEnabled) { $_o9zdak20hww6reelpmd0ffsit6 .="\40\40\40\55\55\x3e\x3c\x64\x69\x76\40\143\x6c\x61\x73\163\x3d\"\x4c\x42\104\x5f\x50\154\141\x63\145\x68\157\154\x64\145\x72\"\40\151\x64\75\"{$this->_0o8ntu9wqm7wj92q}\137\101\165\144\151\x6f\x50\x6c\x61\x63\145\150\157\x6c\144\x65\x72\"\x3e\46\156\142\163\x70\x3b\74\57\x64\x69\166\76\x3c\41\x2d\55\r\n"; } $_o9zdak20hww6reelpmd0ffsit6 .= "\40\x2d\x2d\x3e\x3c\x2f\144\x69\x76\76\r\n"; } return $_o9zdak20hww6reelpmd0ffsit6; } private function fb6su($_060cnd9fwxv4w2hphviqy1znxs) { $_lvmea8wq4wx9q9e3 = $this->_1rge4xcus73aw8yx->AutoFocusInput ? "\164\162\165\x65" : "\146\x61\x6c\x73\145"; $_Owudrwqjnsmsx81xa654np7cdx = $this->_1rge4xcus73aw8yx->AutoClearInput ? "\x74\x72\x75\x65" : "\146\141\154\x73\x65"; $_18sco1i7ssq6udse14ots4bvb8 = false; if (isset($this->_1rge4xcus73aw8yx->AutoLowercaseInput)) { $_18sco1i7ssq6udse14ots4bvb8 = $this->_1rge4xcus73aw8yx->AutoLowercaseInput ? "\164\162\165\x65" : "\146\141\x6c\163\145"; } else if (isset($this->_1rge4xcus73aw8yx->AutoUppercaseInput)) { $_18sco1i7ssq6udse14ots4bvb8 = $this->_1rge4xcus73aw8yx->AutoUppercaseInput ? "\164\162\x75\x65" : "\x66\141\x6c\163\145"; } $_l5rgqtk3ru4aeio9rs5javf7ip = $this->_1rge4xcus73aw8yx->AutoReloadExpiredCaptchas ? "\164\x72\x75\145" : "\x66\141\154\163\145"; $_1t4rcsxcslud0p75jmkgv = $this->_1rge4xcus73aw8yx->AutoReloadTimeout; $_I9fb4d5rmnqzpuldm6slx2bnbk = $this->_1rge4xcus73aw8yx->SoundStartDelay; $_1lta8hqpnjuoc8xhxaz8f = ($this->SoundRegenerationMode == SoundRegenerationMode::Limited) ? "\164\x72\165\145" : "\146\x61\x6c\163\x65"; $_060cnd9fwxv4w2hphviqy1znxs .= "\x20\x20\x20\40\x3c\x73\x63\162\151\160\164\40\x73\x72\143\75\"{$this->ScriptIncludeUrl}\"\x20\x74\x79\x70\x65\x3d\"\164\x65\x78\164\57\152\x61\166\141\x73\143\162\151\x70\164\"\x3e\x3c\x2f\163\x63\162\x69\x70\x74\x3e\r\n"; $_060cnd9fwxv4w2hphviqy1znxs .= "\x20\x20\40\x20\74\163\x63\162\151\160\x74\x20\x74\171\x70\x65\x3d\"\x74\145\x78\x74\57\152\x61\166\x61\x73\143\162\x69\160\x74\"\x3e\x2f\x2f\x3c\x21\133\103\x44\101\124\x41\133\r\n"; $_060cnd9fwxv4w2hphviqy1znxs .= "\40\40\x20\40\x20\x20\102\157\x74\x44\145\x74\x65\143\x74\56\111\156\151\x74\50\47{$this->_0o8ntu9wqm7wj92q}\x27\54\x20\x27{$this->InstanceId}\x27\x2c\40\47{$this->_Ieyxjha5o0e5ernvzl153vpxmq}\x27\x2c\40{$_lvmea8wq4wx9q9e3}\x2c\40{$_Owudrwqjnsmsx81xa654np7cdx}\54\x20{$_18sco1i7ssq6udse14ots4bvb8}\54\x20{$_l5rgqtk3ru4aeio9rs5javf7ip}\x2c\x20{$this->CodeTimeout}\x2c\40{$_1t4rcsxcslud0p75jmkgv}\54\40{$_I9fb4d5rmnqzpuldm6slx2bnbk}\54\40{$_1lta8hqpnjuoc8xhxaz8f}\x29\x3b\r\n"; $_060cnd9fwxv4w2hphviqy1znxs .= "\x20\x20\x20\x20\57\x2f\x5d\135\x3e\74\57\x73\x63\162\151\160\164\x3e\r\n"; $_060cnd9fwxv4w2hphviqy1znxs .= "\40\40\40\40\74\x69\x6e\160\x75\x74\40\x74\x79\160\x65\x3d\"\150\151\x64\144\145\x6e\"\40\156\x61\x6d\145\x3d\"{$this->_omkbzcbtzxsbricspk7sp}\"\x20\x69\144\75\"{$this->_omkbzcbtzxsbricspk7sp}\"\x20\166\x61\154\x75\145\75\"{$this->InstanceId}\"\x20\57\x3e\r\n"; $_060cnd9fwxv4w2hphviqy1znxs .= "\40\x20\x20\x20\74\151\x6e\160\x75\164\40\164\x79\160\x65\x3d\"\x68\151\144\144\x65\156\"\40\x6e\x61\155\x65\x3d\"\114\102\104\137\102\x61\143\153\x57\x6f\x72\x6b\x61\x72\157\x75\156\x64\x5f{$this->_0o8ntu9wqm7wj92q}\"\40\151\x64\x3d\"\x4c\102\104\x5f\x42\x61\x63\x6b\127\x6f\162\153\x61\x72\157\x75\x6e\144\x5f{$this->_0o8ntu9wqm7wj92q}\"\x20\166\141\x6c\165\145\75\"\60\"\40\x2f\x3e\r\n"; return $_060cnd9fwxv4w2hphviqy1znxs; } private function on3tr($_ij8shkk2oqudq0dtx4qb0cjqt2) { $this->_osur8jv8mncvsjhzvqqprfc9av = LBD_RemoteScriptHelper::GetRemoteScriptEnabled($this->_osur8jv8mncvsjhzvqqprfc9av); if ($this->_osur8jv8mncvsjhzvqqprfc9av) { $_ij8shkk2oqudq0dtx4qb0cjqt2 .= LBD_RemoteScriptHelper::GetRemoteScriptMarkup(); } return $_ij8shkk2oqudq0dtx4qb0cjqt2; } public static function IsFree() { return LBD_CaptchaBase::IsFree; } public static function GetProductInfo() { return LBD_CaptchaBase::$ProductInfo; } private function j405s() { return $this->HelpLinkHeight; } public function __get($_I9lbkbmrmkuemzy6nlq9v) { if (method_exists($this->_io49fyn64f2v2imhhhn1x, ($_0q4v5j3wpawtv42z9zl2e = "\x67\145\x74\x5f".$_I9lbkbmrmkuemzy6nlq9v))) { return $this->_io49fyn64f2v2imhhhn1x->$_0q4v5j3wpawtv42z9zl2e(); } else if (method_exists($this, ($_0q4v5j3wpawtv42z9zl2e = "\x67\145\x74\x5f".$_I9lbkbmrmkuemzy6nlq9v))) { return $this->$_0q4v5j3wpawtv42z9zl2e(); } else return; } public function __isset($_0f3mizc3qmnv2n8cj62752634y) { if (method_exists($this->_io49fyn64f2v2imhhhn1x, ($_lgzc2cdh75i3ktgf9f4bo = "\151\163\x73\x65\164\137".$_0f3mizc3qmnv2n8cj62752634y))) { return $this->_io49fyn64f2v2imhhhn1x->$_lgzc2cdh75i3ktgf9f4bo(); } else if (method_exists($this, ($_lgzc2cdh75i3ktgf9f4bo = "\151\x73\163\145\x74\137".$_0f3mizc3qmnv2n8cj62752634y))) { return $this->$_lgzc2cdh75i3ktgf9f4bo(); } else return; } public function __set($_Osghkkzivgbh1s7n1gkiv, $_1ef8w3pmeoil5bzw3dklh) { if (method_exists($this->_io49fyn64f2v2imhhhn1x, ($_1vn84q5luudy0vhn1pkjioc3nk = "\163\145\164\x5f".$_Osghkkzivgbh1s7n1gkiv))) { $this->_io49fyn64f2v2imhhhn1x->$_1vn84q5luudy0vhn1pkjioc3nk($_1ef8w3pmeoil5bzw3dklh); } else if (method_exists($this, ($_1vn84q5luudy0vhn1pkjioc3nk = "\163\x65\x74\x5f".$_Osghkkzivgbh1s7n1gkiv))) { $this->$_1vn84q5luudy0vhn1pkjioc3nk($_1ef8w3pmeoil5bzw3dklh); } } public function __unset($_1jwtp06oumfsiq2jhuiiogqk5r) { if (method_exists($this->_io49fyn64f2v2imhhhn1x, ($_Opz5ojqiolkyeg06eo0x3 = "\x75\156\163\145\x74\x5f".$_1jwtp06oumfsiq2jhuiiogqk5r))) { $this->_io49fyn64f2v2imhhhn1x->$_Opz5ojqiolkyeg06eo0x3(); } else if (method_exists($this, ($_Opz5ojqiolkyeg06eo0x3 = "\165\156\x73\145\x74\x5f".$_1jwtp06oumfsiq2jhuiiogqk5r))) { $this->$_Opz5ojqiolkyeg06eo0x3(); } } } ?>