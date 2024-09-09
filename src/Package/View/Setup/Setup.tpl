{{R3M}}
{{$register = Package.Raxon.Org.Log:Init:register()}}
{{if(!is.empty($register))}}
{{Package.Raxon.Org.Log:Import:role.system()}}
{{Package.Raxon.Org.Log:Import:log.handler()}}
{{Package.Raxon.Org.Log:Import:log.processor()}}
{{Package.Raxon.Org.Log:Import:log()}}
{{/if}}