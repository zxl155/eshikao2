<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2018062360348971",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCK09ea6OBGHLlgugWCoFJtt2lJPezUCbtfjw79eXMGd8+Dk18uoZtEztJ1REKCLyIhiu1M8DGcnJTwVEBVc1WqEe+PvtT6EJdYCpPMDWmI6x27CKATZMGHhCAYxcICBp3LYP1p7sPcwvSFA4u2WUYxQoCpiRObORqq4VhFCtEi0qjZOtENqL6FIIh7w31Fll0eIwCDVj8DSASZk7y9+wZvdBnDFgeJsgvSmQT6PrNxCIWMkG9/twbLHy3grN3PJRAeFA7pL1h9RDrkGcssq/SXaCAnAYjR+RLL5qNDLJsOPJVOIkKyjfe5yfTvhDePSanYP1s7vn//HiyyBhJ+co8dAgMBAAECggEASRX5nd4XpBGfLmMAX6KTgptaXGqzcXWmJUqlM6Bqg+8zWiuNonkFyxWvCnljIjI6H7qJ70VMeQyeBF/2doX/hUdn/R8T9IojgwAeiwBMnP5aaorB6zPSBsvyMdh6qKJfFCD9iHVgu6oPHK+fL+KT538BST+XCNLpTSjRVZe6PkAoR3/lgWW07WZvyeJTNdJMJ3mMA6cIi/VhqfNw8IlkcIAowUXkmDyyd/mg+wLM0FsYdrxtgaPrGRnk7sE0wWsUTq5M7fR+8wiZS+ll1tKuyzdNWeAUAumfZkUJoZlPzMAIpzOsgU0xbsbv8BGAtUyCGqHg0lqNKfHeXok5cVuKAQKBgQDyUQAl/iGooUHQVt8Xm1ULdjA+yjPSaMXXDMR4QPGQDekkNFEXKeOKxcxwplnIQmlk9U6Q99KwiecOX84RmVjkZcTnpCJg4XLD5PVcg+Gga7bXloAn+nJPdVpGN1V68PdRxqPDpUaJc1pBCjLtSCMrIGi2pGsQ0pZyPpuf7r5n3QKBgQCSqsZVCkAmNKHpg3M02yunNW6v4H8YyA1Y/ahSTesbow5EPfogIKOkShJVdj/yYrl6AFxEb0bw/uw/UKAWs26MjQg1JJm3GpjogHrrhOOiI6ncANENt5+tNn3DDL0SRLc8vQTA36YtSs+yECJgQ7LS5Tfr3VRboFi2uRssg3fwQQKBgE2NjR2bw0wEKFs0onwcs9BSSEigUIukCsW0CWFvb6CqQxbaQ6XFO1Ubzz2ykAOe9bphJH8TQfRMfo3ELeDGEoQu6iE1D+ev4BpAOiMc9mZwcvl26pdg+ZritTzJ0urhGlaq25jvWa7+I0GzsO7uaosP+VOTNc0RiSMRVJ+QOpJlAoGAVRoISNHQ1RpXFJK0Z2gA1V3You6lcLCrpgZRA6i4kemz3n8Dwl6N9UcRiks54Z/NNXA+GWtkA3Q3iqlyqplkvOMcbxGUq70gGlBqgnwyRSNibQiARPBWE4B5ypJ6pr3+gJzAxFVBLCiriQt5ltfRTDO6lf5v81aAA0426UZDcsECgYBX2f/rbYxBBQXjUoaM0F7jAYgeDdzkH1r7scZslCq8XQAq80OlGrrlsE7nDvxNbAsA1mjRVGbPu+458jLVhDJtFiu8YrZSsZhrUtjVMZ1sOuJvxZ/iU9K7Rnw/8qLcDKmQ5ZWkqn0STiP9bIbfNeGqEgVaK+9NeVX+4zNK1WXOyA==",
		
		//异步通知地址
		'notify_url' => "http://www.eshikao.com/home/moveNotify",
		
		//同步跳转
		'return_url' => "http://www.eshikaojiaoyu.com/home/moveSuccess",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAw7nOnFqfbml6HRVn4kMAgy6ECo95Sj7DjlSDBkD3NOmOecjYG276FwYrbzDWCgXPaDO0/hcr47aiKpzwqCbS84aoDiY1SE+x0Ixf2/BJ72RLg3zSac0FpBL3stN/keYZVdW6akdczkzIGznHL/BENAcU91IV68udaGQll+Agt9uA+oFxMn1R1n+LcBVVypYuJsRB5F+IcNadcaW6vZR6/wjWbqAQHbshR3MaTwCTXWrgde4PrXnqUCzTVl++ses0UwLY9fcrgJhv+dxaxgHGpub2XaFhcqus8I91ZXjENod6R7+SbTZFQJOIn1TBPM7lF+wuY98aAy7iZGmVLi5POwIDAQAB",
		
	
);