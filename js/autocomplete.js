(function ( $ ) {
  $.fn.wpAutoComplete = function( options ) {
    'use strict';

    var defaults = {
      'per_page' : 10,
      'timer'    : 2000
    };
    var settings = $.extend( {}, defaults, options );
    var timer = false;

    this.after( $( document.createElement( 'datalist' ) ).attr( 'id', 'search-list' ) );
    this.attr({
      'autocomplete': 'on',
      'list': 'search-list'
    });

    /**
     * Key Bind.
     */
    this.on( 'keyup', function() {
      var
        text = $(this).val();

      if ( text === '' ) return;
      if ( timer !== false ) clearTimeout( timer );

      timer = setTimeout( function() {
        sendRestApi( text );
        timer = false;
      }, settings.timer );
    });

    /**
     * WP REST API send.
     * @param {string} text
     */
    function sendRestApi( text ) {
      var
        param = '?per_page=' + Number( settings.per_page )
              + '&search='   + changeSpace( escapeHtml( text ) );

      $.ajax({
        url     : '/wp-json/wp/v2/posts' + param,
        type    : 'get',
        dataType: 'json'
      })
      .done( function( data ) {
        var dataList = $('#search-list').empty();

        data.forEach( function( item ) {
          dataList.append(
              $( document.createElement( 'option' ) ).val( item.title.rendered )
          );
        })
      })
      .fail( function( data ) {
        console.log(data);
      });
    }

    /**
     * Sanitize string.
     * @param   {string} string
     * @returns {string}
     */
    function escapeHtml( string ) {
      if ( typeof string !== 'string' ) {
        return string;
      }
      return string.replace(/[&'`"<>]/g, function ( match ) {
        return {
          '&': '&amp;',
          "'": '&#x27;',
          '`': '&#x60;',
          '"': '&quot;',
          '<': '&lt;',
          '>': '&gt;'
        }[match]
      });
    }

    /**
     * Change space.
     * @param   {string} string
     * @returns {string}
     */
    function changeSpace( string ) {
      if ( typeof string !== 'string' ) {
        return string;
      }
      return string.trim().replace(/[ 　]/g, function( match ) {
        return {
          ' ' : ',',
          "　": ','
        }[match]
      });
    }
  };
}( jQuery ) );