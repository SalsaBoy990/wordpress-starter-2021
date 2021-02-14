-- Szükség szerint bővítendő a lista
-- Itt csak a legminimálisabb felülírások szerepelnek a legfontosabb táblákban
-- Alternatíva: kódszerkesztőben az éles oldalról kiexportált adatbázis szkriptben
-- keress rá a domain-edre (http://www.sajatadomainnevem.hu) és cseréld le pl. http://localhost:8000-ra
UPDATE `wp_options`
SET `option_value` = replace(`option_value`, 'http://www.sajatadomainnevem.hu', 'https://www.sajatadomainnevem.hu')
WHERE `option_name` = 'home' OR `option_name` = 'siteurl';

UPDATE `wp_posts`
SET `guid` = replace(`guid`, 'http://www.sajatadomainnevem.hu','https://www.sajatadomainnevem.hu');

UPDATE `wp_posts`
SET `post_content` = replace(`post_content`, 'http://www.sajatadomainnevem.hu', 'https://www.sajatadomainnevem.hu');

UPDATE `wp_postmeta`
SET `meta_value` = replace(`meta_value`,'http://www.sajatadomainnevem.hu','https://www.sajatadomainnevem.hu');