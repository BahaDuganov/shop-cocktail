define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
	'Magento_Ui/js/modal/modal',
	'notifyJS'
], function ($, ko, Component, urlBuilder, storage, modal, notifyJS) {
    'use strict';
    
    return Component.extend({

        defaults: {
            template: 'Aislend_Instruction/instruction-detail',
        },

        initialize: function () {
            this._super();
			var quoteid = this.quoteid;
			var itemid = this.itemid;						
        },
		
		openModal: function()
		{
			var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Instruction',
				autoOpen: true
            };
			var popup = modal(options, $('#instruction-info'));
            $("#instruction-modal-box").on('click',function(){
                $("#instruction-info").modal("openModal");
            });
		},
		
		getTextAreBoxId: function()
		{
			var name = 'instruction-info_'+this.itemid;
			return name;
		},
		
		getTextAreBoId: function()
		{
			var name = 'add_instruction_'+this.itemid;
			return name;
		},
		
		isVisible: function()
		{
			$('#instruction-info_'+this.itemid).toggle();
			$('#instruction-info_'+this.itemid).addClass('show');
			$('#add_instruction_'+this.itemid).css("display","none");
			$('#edit_text_'+this.itemid).css("display","none");			
			return;
		},
		
		cancelBox: function()
		{
			$('#instruction-info_'+this.itemid).toggle();
			$('#add_instruction_'+this.itemid).css("display","block");
			$('#instruction-info_'+this.itemid).removeClass('show');
			$('#edit_text_'+this.itemid).css("display","block");
			return;
		},
		
		getAllowedName: function()
		{
			var name = 'allowed_'+this.itemid;
			return name;
		},
		getNotAllowedName: function()
		{
			var name = 'notallowed_'+this.itemid;
			return name;
		},
		
		isChecked: function()
		{
			var checked = false;
			if((this.substitue && this.substitue == 1) || this.substitue == "")
			{				
				checked = true;
			}
			return checked;
		},
		
		isNotChecked: function()
		{			
			var checked = false;
			if(this.substitue && this.substitue == 0)
			{				
				checked = true;
			}
			return checked;
		},
		
		getInstructionInfo: function()
		{
			if(this.instruction)
			{
				return this.instruction;
			}
			return;
		},
		
		getInstructionText: function()
		{
			var instText = 'Add Instruction';
			if(this.instruction)
			{
				instText = 'Edit Instruction';
			}
			return instText;
		},
		
		getEditTextId: function()
		{
			var name = 'edit_text_'+this.itemid;
			return name;
		},
		
		getRemoveButton: function()
		{
			var hCLass = 'hide';			
			if(this.instruction)
			{
				hCLass = 'show';
			}
			
			return hCLass;
		},
		
		
		getSubstitute: function(dataval, quoteid, itemid, checkboxType)
		{			
			var data = 'action=add&quoteid=' + this.quoteid +'&itemid='+this.itemid;
				data += '&substitue='+dataval;			
			var self = this;
			$.ajax({
				type: "POST",
				url: '/instruction/index/additionaloptions?'+data,				
				success: function(response) 
				{					
					notifyJS.showMessage(response.status, response.msg, response.status);
					return true;
				},
				error: function(error) {
				
				}
				
			});
			return true;
		},
		
		addInstruction: function()
		{				
			var self = this;
			var textareaVal = $('#instruction-info_'+this.itemid+' textarea').val();
			var Error = false;
			if(textareaVal.trim() == '' || textareaVal.trim() == null)
			{
				Error = true;
				$('#instruction-info_'+this.itemid+' textarea').css('border-color','red');
				return false;
			}else
			{
				$('#instruction-info_'+this.itemid+' textarea').css('border-color','');
			}
			$('body').trigger('processStart');
			var data = 'action=add&quoteid=' + this.quoteid +'&itemid='+this.itemid;
				data += '&instruction='+textareaVal;
			var itemid = this.itemid;
			var serviceUrl = urlBuilder.build('/instruction/index/additionaloptions?'+data);			
			return storage.post(serviceUrl, '')
                .done(
                    function (response) {
						$('body').trigger('processStop');
						self.cancelBox();
						$('#edit_text_'+itemid	+'> .cc__gift-message-summary').text(textareaVal);
						$('#edit_text_'+itemid).addClass('cc__instruction-summary _block cc__instruction-relative');
						$('#add_instruction_'+itemid).html('<span>Edit Instruction</span>');
						$('#edit_text_'+itemid).show();
						$('#'+self.name).find('.hide').removeClass('hide').addClass('show');						
						$('#instruction-info_'+itemid).removeClass('show');
                        notifyJS.showMessage(response.status, response.msg, response.status);						              
                    }
                ).fail(
                    function (response) {
                        $('body').trigger('processStop');
                    }
			);
		},
		
		getRemove: function()
		{
			var self = this;
			var data = 'action=remove&quoteid=' + this.quoteid +'&itemid='+this.itemid;				
			var itemid = this.itemid;
			var serviceUrl = urlBuilder.build('/instruction/index/additionaloptions?'+data);
			var itemid = this.itemid;
			$('body').trigger('processStart');			
			return storage.post(serviceUrl, '')
                .done(
                    function (response) {
						$('body').trigger('processStop');
                        $('#edit_text_'+itemid).attr("class", "");
						$('#edit_text_'+itemid	+'> .cc__gift-message-summary').text('');
						$('#add_instruction_'+itemid).html('<span>Add Instruction</span>');
						$('#instruction-info_'+itemid+' textarea').val('');
						$('#add_instruction_'+itemid).show('');
						$('#'+self.name).find('.show').removeClass('show').addClass('hide');
                        notifyJS.showMessage(response.status, response.msg, response.status);						              
                    }
                ).fail(
                    function (response) {
                        $('body').trigger('processStop');
                    }
			);
		}		
		
    });
});