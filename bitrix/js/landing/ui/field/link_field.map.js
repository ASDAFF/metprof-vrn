{"version":3,"sources":["link_field.js"],"names":["BX","namespace","trim","Landing","Utils","clone","isPlainObject","decodeDataValue","fireCustomEvent","htmlToElement","style","UI","Field","Link","data","BaseField","apply","this","arguments","options","remove","input","onValueChangeHandler","onValueChange","content","text","href","target","Text","placeholder","message","selector","textOnly","getValue","bind","hrefInput","LinkURL","title","onInput","onHrefInput","disallowType","disableBlocks","disableCustomURL","allowedTypes","noHrefValueChange","targetInput","DropdownInline","className","items","_self","_blank","_popup","mediaButton","Button","BaseButton","html","onClick","onMediaClick","mediaLayout","create","props","mediaHelpButton","layout","addEventListener","onMediaHelpButtonMouseover","onMediaHelpButtonMouseout","containsImage","containsHtml","hidden","header","innerHTML","wrapper","createWrapper","left","createLeft","center","createCenter","right","createRight","appendChild","classList","add","adjustVideo","prototype","constructor","__proto__","superClass","isChanged","JSON","stringify","querySelector","element","matches","value","isAvailableMedia","isEnabledMedia","attrs","data-url","mediaService","getEmbedURL","getDynamic","firstElementChild","getAttribute","setValue","reset","enableMedia","enable","disable","closePopup","showMediaPreview","disableMedia","hideMediaPreview","hideMediaSettings","isEnabled","showMediaSettings","mediaSettings","getSettingsForm","ServiceFactory","MediaService","Factory","event","Tool","Suggest","getInstance","show","description","children","outerHTML","angleOffset","hide","onVideoPreviewClick","$","fancybox","open","src","type","iframe","scrolling","loader","Card","Loader","video","getURLPreviewElement","then","embedURL","getQueryParams","url"],"mappings":"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","file":""}